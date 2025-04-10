<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Destination;
use App\Models\Activity;
use App\Models\Itinerary;
use App\Models\Traveller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TripController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Allow public access to index and show methods
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the trips.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get trips to display for public viewing
        $featuredTrips = Trip::with(['activities', 'travellers'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        // Get all trips for the main listing with pagination
        $trips = Trip::with(['categories', 'tags', 'hotels', 'transportCompanies', 'guides', 'itinerary'])
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        
        // If user is authenticated, also get their personal trips
        $userTrips = [];
        if (Auth::check()) {
            $userTrips = Trip::whereHas('travellers', function($query) {
                $query->where('user_id', Auth::id());
            })->paginate(10);
        }
        
        return view('trips.index', compact('trips', 'featuredTrips', 'userTrips'));
    }

    /**
     * Show the form for creating a new trip.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $destinations = Destination::all();
        return view('trips.create', compact('destinations'));
    }

    /**
     * Store a newly created trip in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate trip data
        $validator = Validator::make($request->all(), [
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Handle cover picture upload
        $coverPicture = null;
        if ($request->hasFile('cover_picture')) {
            $coverPicture = $request->file('cover_picture')->store('trips', 'public');
            $coverPicture = basename($coverPicture); // Get just the filename
        }
        
        // Create a new trip
        $trip = Trip::create([
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'cover_picture' => $coverPicture,
        ]);
        
        // Create an empty itinerary for the trip
        $itinerary = Itinerary::create([
            'title' => $request->destination . ' Trip',
            'description' => 'Itinerary for trip to ' . $request->destination,
        ]);
        
        // Update trip with itinerary
        $trip->itinerary()->associate($itinerary);
        $trip->save();
        
        // Create traveller entry for the current user
        Traveller::create([
            'user_id' => Auth::id(),
            'trip_id' => $trip->id,
            'itinerary_id' => $itinerary->id,
        ]);
        
        return redirect()->route('trips.show', $trip->id)
            ->with('success', 'Trip created successfully!');
    }

    /**
     * Display the specified trip.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip = Trip::with(['itinerary', 'activities', 'travellers.user'])->findOrFail($id);
        
        // Check if the trip is accessible to the current user
        $canEdit = false;
        if (Auth::check()) {
            $isTraveller = $trip->travellers()->where('user_id', Auth::id())->exists();
            $isAdmin = Auth::user()->hasRole('admin') ?? false;
            $canEdit = $isTraveller || $isAdmin;
        }
        
        return view('trips.show', compact('trip', 'canEdit'));
    }

    /**
     * Show the form for editing the specified trip.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        
        // Check if the user has access to this trip
        $this->authorizeAccess($trip);
        
        $destinations = Destination::all();
        return view('trips.edit', compact('trip', 'destinations'));
    }

    /**
     * Update the specified trip in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);
        
        // Check if the user has access to this trip
        $this->authorizeAccess($trip);
        
        // Validate trip data
        $validator = Validator::make($request->all(), [
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Handle cover picture upload
        if ($request->hasFile('cover_picture')) {
            // Delete old picture if exists
            if ($trip->cover_picture) {
                Storage::disk('public')->delete('trips/' . $trip->cover_picture);
            }
            
            $coverPicture = $request->file('cover_picture')->store('trips', 'public');
            $trip->cover_picture = basename($coverPicture);
        }
        
        // Update trip details
        $trip->update([
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        
        return redirect()->route('trips.show', $trip->id)
            ->with('success', 'Trip updated successfully!');
    }

    /**
     * Remove the specified trip from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        
        // Check if the user has access to this trip
        $this->authorizeAccess($trip);
        
        // Delete related records
        $trip->activities()->delete();
        $trip->travellers()->delete();
        
        // Delete itinerary if it exists
        if ($trip->itinerary) {
            $trip->itinerary->delete();
        }
        
        // Delete the trip
        $trip->delete();
        
        return redirect()->route('trips.index')
            ->with('success', 'Trip deleted successfully!');
    }
    
    /**
     * Add activity to a trip.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $tripId
     * @return \Illuminate\Http\Response
     */
    public function addActivity(Request $request, $tripId)
    {
        $trip = Trip::findOrFail($tripId);
        
        // Check if the user has access to this trip
        $this->authorizeAccess($trip);
        
        // Validate activity data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Create new activity
        $activity = Activity::create([
            'trip_id' => $trip->id,
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
        ]);
        
        return redirect()->route('trips.show', $tripId)
            ->with('success', 'Activity added successfully!');
    }
    
    /**
     * Remove an activity.
     *
     * @param  int  $tripId
     * @param  int  $activityId
     * @return \Illuminate\Http\Response
     */
    public function removeActivity($tripId, $activityId)
    {
        $trip = Trip::findOrFail($tripId);
        
        // Check if the user has access to this trip
        $this->authorizeAccess($trip);
        
        $activity = Activity::where('id', $activityId)
            ->where('trip_id', $tripId)
            ->firstOrFail();
            
        $activity->delete();
        
        return redirect()->route('trips.show', $tripId)
            ->with('success', 'Activity removed successfully!');
    }
    
    /**
     * Update itinerary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $tripId
     * @return \Illuminate\Http\Response
     */
    public function updateItinerary(Request $request, $tripId)
    {
        $trip = Trip::with('itinerary')->findOrFail($tripId);
        
        // Check if the user has access to this trip
        $this->authorizeAccess($trip);
        
        // Validate itinerary data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Update itinerary
        if ($trip->itinerary) {
            $trip->itinerary->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        } else {
            // Create new itinerary if it doesn't exist
            $itinerary = Itinerary::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);
            
            $trip->itinerary()->associate($itinerary);
            $trip->save();
        }
        
        return redirect()->route('trips.show', $tripId)
            ->with('success', 'Itinerary updated successfully!');
    }
    
    /**
     * Add traveller to a trip.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $tripId
     * @return \Illuminate\Http\Response
     */
    public function addTraveller(Request $request, $tripId)
    {
        $trip = Trip::with('itinerary')->findOrFail($tripId);
        
        // Check if the user has access to this trip
        $this->authorizeAccess($trip);
        
        // Validate traveller data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'nationality' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Find user by email
        $user = \App\Models\User::where('email', $request->email)->first();
        
        // Check if user is already a traveller on this trip
        $existingTraveller = Traveller::where('user_id', $user->id)
            ->where('trip_id', $trip->id)
            ->first();
            
        if ($existingTraveller) {
            return redirect()->back()->with('error', 'This user is already part of the trip.');
        }
        
        // Add traveller
        Traveller::create([
            'user_id' => $user->id,
            'trip_id' => $trip->id,
            'itinerary_id' => $trip->itinerary->id,
            'nationality' => $request->nationality,
            'passport_number' => $request->passport_number,
            'prefered_destination' => null,
        ]);
        
        return redirect()->route('trips.show', $tripId)
            ->with('success', 'Traveller added successfully!');
    }
    
    /**
     * Remove a traveller.
     *
     * @param  int  $tripId
     * @param  int  $travellerId
     * @return \Illuminate\Http\Response
     */
    public function removeTraveller($tripId, $travellerId)
    {
        $trip = Trip::findOrFail($tripId);
        
        // Check if the user has access to this trip
        $this->authorizeAccess($trip);
        
        $traveller = Traveller::where('id', $travellerId)
            ->where('trip_id', $tripId)
            ->firstOrFail();
            
        $traveller->delete();
        
        return redirect()->route('trips.show', $tripId)
            ->with('success', 'Traveller removed successfully!');
    }
    
    /**
     * Check if user has access to a trip.
     *
     * @param  Trip  $trip
     * @return bool
     */
    private function authorizeAccess(Trip $trip)
    {
        $userId = Auth::id();
        
        // Check if user is a traveller on this trip
        $isTraveller = $trip->travellers()->where('user_id', $userId)->exists();
        
        if (!$isTraveller && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
        
        return true;
    }
}

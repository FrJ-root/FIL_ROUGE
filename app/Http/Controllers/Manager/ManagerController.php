<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Trip;
use App\Models\Hotel;
use App\Models\Guide;
use App\Models\Transport;
use App\Models\Traveller;
use App\Models\Activity;
use App\Models\Itinerary;
use App\Models\User;

class ManagerController extends Controller
{
    /**
     * Display a listing of trips
     */
    public function index()
    {
        $trips = Trip::with(['hotels', 'guides', 'transports', 'travellers'])
            ->latest()
            ->paginate(9);
            
        // If user is authenticated, get their trips too
        $userTrips = auth()->check() 
            ? Trip::whereHas('travellers', function($query) {
                $query->where('user_id', auth()->id());
            })->latest()->paginate(9)
            : null;
        
        // Pass a flag to show if the user can create trips (only managers)
        $canCreateTrips = auth()->check() && auth()->user()->role === 'manager';
            
        return view('trips.index', compact('trips', 'userTrips', 'canCreateTrips'));
    }

    /**
     * Show the form for creating a new trip
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * Store a newly created trip
     */
    public function store(Request $request)
    {
        $request->validate([
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_picture' => 'nullable|image|max:2048'
        ]);

        $trip = new Trip([
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if ($request->hasFile('cover_picture')) {
            $path = $request->file('cover_picture')->store('images/trip', 'public');
            $trip->cover_picture = basename($path);
        }

        $trip->save();

        // Create default itinerary
        $itinerary = new Itinerary([
            'title' => 'Trip to ' . $request->destination,
            'description' => 'Default itinerary for ' . $request->destination,
        ]);
        
        $trip->itinerary()->save($itinerary);

        // Add the creator as a traveller
        $traveller = Traveller::firstOrCreate(
            ['user_id' => Auth::id()],
            ['passport_number' => null]
        );
        
        $traveller->trip_id = $trip->id;
        $traveller->itinerary_id = $itinerary->id;
        $traveller->save();

        return redirect()->route('trips.show', $trip->id)
            ->with('success', 'Trip created successfully!');
    }

    /**
     * Display the specified trip
     */
    public function show(Trip $trip)
    {
        $trip->load(['hotels', 'guides', 'transports', 'travellers', 'activities', 'itinerary']);
        
        // Get related trips
        $relatedTrips = Trip::where('id', '!=', $trip->id)
            ->take(3)
            ->get();
            
        $canEdit = auth()->check() && (
            auth()->user()->role === 'admin' || 
            auth()->user()->role === 'manager' ||
            ($trip->travellers->contains('user_id', auth()->id()) && $trip->travellers->count() === 1)
        );
            
        return view('trips.show', compact('trip', 'relatedTrips', 'canEdit'));
    }

    /**
     * Show the form for editing the specified trip
     */
    public function edit(Trip $trip)
    {
        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the specified trip
     */
    public function update(Request $request, Trip $trip)
    {
        $request->validate([
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cover_picture' => 'nullable|image|max:2048'
        ]);

        $trip->destination = $request->destination;
        $trip->start_date = $request->start_date;
        $trip->end_date = $request->end_date;

        if ($request->hasFile('cover_picture')) {
            // Delete old image if exists
            if ($trip->cover_picture) {
                Storage::disk('public')->delete('images/trip/' . $trip->cover_picture);
            }
            
            $path = $request->file('cover_picture')->store('images/trip', 'public');
            $trip->cover_picture = basename($path);
        }

        $trip->save();

        return redirect()->route('trips.show', $trip->id)
            ->with('success', 'Trip updated successfully!');
    }

    /**
     * Remove the specified trip
     */
    public function destroy(Trip $trip)
    {
        // Delete cover picture if exists
        if ($trip->cover_picture) {
            Storage::disk('public')->delete('images/trip/' . $trip->cover_picture);
        }

        $trip->delete();

        return redirect()->route('trips.index')
            ->with('success', 'Trip deleted successfully!');
    }

    /**
     * Add traveller to trip
     */
    public function addTraveller(Request $request, Trip $trip)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'nationality' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Check if user is already a traveller on this trip
        $existingTraveller = Traveller::where('user_id', $user->id)
            ->where('trip_id', $trip->id)
            ->first();

        if ($existingTraveller) {
            return redirect()->back()->with('error', 'This traveller is already on the trip.');
        }

        // Create or update traveller
        $traveller = Traveller::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nationality' => $request->nationality,
                'passport_number' => $request->passport_number,
            ]
        );

        // Update with new values if exists
        if ($request->nationality) {
            $traveller->nationality = $request->nationality;
        }
        
        if ($request->passport_number) {
            $traveller->passport_number = $request->passport_number;
        }

        $traveller->trip_id = $trip->id;
        $traveller->itinerary_id = $trip->itinerary->id;
        $traveller->save();

        return redirect()->back()->with('success', 'Traveller added to trip successfully!');
    }

    /**
     * Remove traveller from trip
     */
    public function removeTraveller(Trip $trip, $travellerId)
    {
        $traveller = Traveller::findOrFail($travellerId);
        
        if ($traveller->trip_id != $trip->id) {
            return redirect()->back()->with('error', 'This traveller is not on this trip.');
        }

        // Reset the trip_id and itinerary_id
        $traveller->trip_id = null;
        $traveller->itinerary_id = null;
        $traveller->save();

        return redirect()->back()->with('success', 'Traveller removed from trip successfully!');
    }

    /**
     * Update trip itinerary
     */
    public function updateItinerary(Request $request, Trip $trip)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if (!$trip->itinerary) {
            $trip->itinerary()->create([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        } else {
            $trip->itinerary->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }

        return redirect()->back()->with('success', 'Itinerary updated successfully!');
    }

    /**
     * Remove activity from trip
     */
    public function removeActivity(Trip $trip, Activity $activity)
    {
        if ($activity->trip_id != $trip->id) {
            return redirect()->back()->with('error', 'This activity does not belong to this trip.');
        }

        $activity->delete();

        return redirect()->back()->with('success', 'Activity removed successfully!');
    }

    /**
     * Display the manager dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $totalTrips = Trip::count();
        $activeTrips = Trip::where('start_date', '>', now())->count();
        $completedTrips = Trip::where('end_date', '<', now())->count();
        
        $hotelsCount = Hotel::count();
        $guidesCount = Guide::count();
        $transportsCount = Transport::count();
        
        $recentTrips = Trip::latest()->take(5)->get();
        
        $pendingCollaborations = Trip::whereDoesntHave('hotels')
            ->orWhereDoesntHave('guides')
            ->orWhereDoesntHave('transports')
            ->take(5)
            ->get();

        return view('manager.dashboard', compact(
            'user',
            'totalTrips',
            'activeTrips',
            'completedTrips',
            'hotelsCount',
            'guidesCount',
            'transportsCount',
            'recentTrips',
            'pendingCollaborations'
        ));
    }

    /**
     * Display trips for manager dashboard
     */
    public function trips()
    {
        $trips = Trip::with(['hotels', 'guides', 'transports', 'travellers', 'activities', 'itinerary'])
            ->latest()
            ->paginate(10);
        
        return view('manager.pages.trips', compact('trips'));
    }

    /**
     * Display trips associated with a specific collaborator type (hotel, guide, transport)
     */
    public function collaboratorTrips($type)
    {
        if (!in_array($type, ['hotel', 'guide', 'transport'])) {
            return redirect()->route('manager.trips')->with('error', 'Invalid collaborator type.');
        }
        
        $query = Trip::with(['hotels', 'guides', 'transports', 'travellers']);
        
        switch ($type) {
            case 'hotel':
                $query->whereHas('hotels');
                $pageTitle = "Hotel Trips";
                $iconClass = "fas fa-hotel text-blue-500";
                break;
            case 'guide':
                $query->whereHas('guides');
                $pageTitle = "Guide Trips";
                $iconClass = "fas fa-user-tie text-green-500";
                break;
            case 'transport':
                $query->whereHas('transports');
                $pageTitle = "Transport Trips";
                $iconClass = "fas fa-bus text-amber-500";
                break;
        }
        
        $trips = $query->latest()->paginate(10);
        
        return view('manager.pages.collaborator-trips', compact('trips', 'type', 'pageTitle', 'iconClass'));
    }

    /**
     * Show collaborators list
     */
    public function collaborators()
    {
        // Fetch all hotels, guides, and transports for the collaborators page
        $hotels = Hotel::with('user')->get();
        $guides = Guide::with('user')->get();
        $transports = Transport::with('user')->get();
        
        return view('manager.pages.collaborators', compact('hotels', 'guides', 'transports'));
    }
}

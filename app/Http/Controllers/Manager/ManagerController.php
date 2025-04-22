<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Trip;
use App\Models\Hotel;
use App\Models\Guide;
use App\Models\Transport;
use App\Models\Traveller;
use App\Models\Activity;
use App\Models\Itinerary;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;

class ManagerController extends Controller
{
    /**
     * Display a listing of all trips.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trips = Trip::with(['travellers', 'guides', 'hotels', 'transports'])
            ->latest()
            ->paginate(12);
        
        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new trip
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('trips.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created trip
     */
    public function store(Request $request)
    {
        // Begin a database transaction to ensure all operations succeed or fail together
        DB::beginTransaction();
        
        try {
            // Validate the form data
            $validated = $request->validate([
                'destination' => 'required|string|max:255',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'cover_picture' => 'nullable|image|max:2048'
            ]);

            // Create the trip with validated data
            $trip = new Trip();
            $trip->destination = $validated['destination'];
            $trip->start_date = $validated['start_date'];
            $trip->end_date = $validated['end_date'];
            $trip->manager_id = Auth::id();
            $trip->status = 'active';

            // Handle file upload if present
            if ($request->hasFile('cover_picture')) {
                $path = $request->file('cover_picture')->store('images/trip', 'public');
                $trip->cover_picture = basename($path);
            }

            // Save the trip and throw an exception if it fails
            if (!$trip->save()) {
                throw new \Exception('Failed to save trip to database');
            }

            // Create the default itinerary
            $itinerary = new Itinerary();
            $itinerary->title = 'Trip to ' . $validated['destination'];
            $itinerary->description = 'Default itinerary for ' . $validated['destination'];
            $itinerary->trip_id = $trip->id;
            
            if (!$itinerary->save()) {
                throw new \Exception('Failed to create itinerary');
            }

            // Add the current user as a traveller if they are a traveller or manager
            if (Auth::user()->role === 'traveller' || Auth::user()->role === 'manager') {
                // Check if user already has a traveller record
                $existingTraveller = Traveller::where('user_id', Auth::id())->first();
                
                if ($existingTraveller) {
                    // Update existing traveller record
                    $existingTraveller->trip_id = $trip->id;
                    $existingTraveller->itinerary_id = $itinerary->id;
                    
                    if (!$existingTraveller->save()) {
                        throw new \Exception('Failed to update traveller with trip information');
                    }
                } else {
                    // Create new traveller record with all required fields
                    $traveller = new Traveller();
                    $traveller->user_id = Auth::id();
                    $traveller->trip_id = $trip->id;
                    $traveller->itinerary_id = $itinerary->id;
                    $traveller->passport_number = null; // Optional field
                    
                    if (!$traveller->save()) {
                        throw new \Exception('Failed to create traveller record');
                    }
                }
            }

            // Commit the transaction as everything succeeded
            DB::commit();
            
            // Get or create a destination based on the trip's destination
            $destinationName = explode(',', $trip->destination)[0];
            $destination = \App\Models\Destination::where('name', 'like', $destinationName . '%')->first();
            
            if ($destination) {
                // Redirect to the destination show page if a matching destination exists
                return redirect()->route('destinations.show', $destination->slug)
                    ->with('success', 'Trip created successfully!');
            }
            
            // Fallback to trip show page if no matching destination
            return redirect()->route('trips.show', $trip->id)
                ->with('success', 'Trip created successfully!');
        } 
        catch (\Exception $e) {
            // Roll back the transaction if anything failed
            DB::rollback();
            
            // Log the detailed error
            \Log::error('Trip creation error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            // Redirect back with input and error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create trip: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified trip
     */
    public function show($id)
    {
        $trip = Trip::with(['travellers.user', 'guides', 'hotels', 'transports', 'activities', 'itinerary', 'categories', 'tags'])
            ->findOrFail($id);
        
        $canEdit = Auth::user()->role === 'manager' && 
                  (Auth::id() === $trip->manager_id || 
                   $trip->travellers->contains('user_id', Auth::id()));
        
        // Get related trips based on destination or categories
        $relatedTrips = Trip::where('id', '!=', $trip->id)
            ->where(function($query) use ($trip) {
                // Match by similar destination
                $query->where('destination', 'like', '%' . explode(',', $trip->destination)[0] . '%')
                // Or match by categories if the trip has categories
                ->orWhereHas('categories', function($categoryQuery) use ($trip) {
                    if ($trip->categories->count() > 0) {
                        $categoryQuery->whereIn('categories.id', $trip->categories->pluck('id'));
                    }
                });
            })
            ->take(3)
            ->get();
        
        return view('trips.show', compact('trip', 'canEdit', 'relatedTrips'));
    }

    /**
     * Show the form for editing the specified trip
     */
    public function edit($id)
    {
        try {
            $trip = Trip::findOrFail($id);
            
            // Make sure to load related data
            $categories = Category::all();
            $tags = Tag::all();
            
            return view('trips.edit', compact('trip', 'categories', 'tags'));
        } catch (\Exception $e) {
            \Log::error('Error showing edit form: ' . $e->getMessage());
            return redirect()->route('manager.trips')->with('error', 'Error loading trip: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified trip
     */
    public function update(Request $request, $id)
    {
        try {
            $trip = Trip::findOrFail($id);
            
            $validated = $request->validate([
                'destination' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'cover_picture' => 'nullable|image|max:2048',
            ]);

            $trip->destination = $validated['destination'];
            $trip->start_date = $validated['start_date'];
            $trip->end_date = $validated['end_date'];

            if ($request->hasFile('cover_picture')) {
                // Delete old image if exists
                if ($trip->cover_picture) {
                    $oldImagePath = 'public/images/trip/' . $trip->cover_picture;
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }
                
                // Store new image
                $path = $request->file('cover_picture')->store('images/trip', 'public');
                $trip->cover_picture = basename($path);
            }

            $trip->save();
            
            // Get or create a destination based on the trip's destination
            $destinationName = explode(',', $trip->destination)[0];
            $destination = \App\Models\Destination::where('name', 'like', $destinationName . '%')->first();
            
            if ($destination) {
                // Redirect to the destination show page if a matching destination exists
                return redirect()->route('destinations.show', $destination->slug)
                    ->with('success', 'Trip updated successfully!');
            }
            
            // Fallback to trip show page if no matching destination
            return redirect()->route('trips.show', $trip->id)
                ->with('success', 'Trip updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating trip: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating trip: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified trip
     */
    public function destroy($id)
    {
        try {
            $trip = Trip::findOrFail($id);
            
            // Delete cover picture if exists
            if ($trip->cover_picture) {
                $picturePath = 'public/images/trip/' . $trip->cover_picture;
                if (Storage::exists($picturePath)) {
                    Storage::delete($picturePath);
                }
            }
            
            // The associated records will be deleted via the database cascade
            $trip->delete();
            
            return redirect()->route('manager.trips')
                ->with('success', 'Trip deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('manager.trips')
                ->with('error', 'Error deleting trip: ' . $e->getMessage());
        }
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

        $existingTraveller = Traveller::where('user_id', $user->id)
            ->where('trip_id', $trip->id)
            ->first();

        if ($existingTraveller) {
            return redirect()->back()->with('error', 'This traveller is already on the trip.');
        }

        $traveller = Traveller::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nationality' => $request->nationality,
                'passport_number' => $request->passport_number,
            ]
        );

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
        $user = auth()->user();
        $today = now()->format('Y-m-d');
        $trips = Trip::where('manager_id', $user->id)->get();
        
        $totalTrips = $trips->count();
        $activeTrips = $trips->where('start_date', '<=', $today)
                             ->where('end_date', '>=', $today)
                             ->where('status', 'active')
                             ->count();
        
        $upcomingTrips = $trips->where('start_date', '>', $today)
                               ->where('status', 'active')
                               ->count();
        
        $totalTravellers = 0;
        $travellers = [];
        
        foreach ($trips as $trip) {
            $tripTravellers = $trip->travellers;
            $totalTravellers += $tripTravellers->count();
            
            foreach ($tripTravellers as $traveller) {
                $travellers[] = $traveller;
            }
        }
        
        $averageTravellers = $totalTrips > 0 ? $totalTravellers / $totalTrips : 0;
        
        $nextTrip = Trip::where('manager_id', $user->id)
                       ->where('start_date', '>', $today)
                       ->where('status', 'active')
                       ->orderBy('start_date')
                       ->first();
        
        $nextTripDays = $nextTrip ? now()->diffInDays($nextTrip->start_date) : null;
        
        $hotelCount = 0;
        $guideCount = 0;
        $transportCount = 0;
        
        foreach ($trips as $trip) {
            $hotelCount += $trip->hotels()->count();
            $guideCount += $trip->guides()->count();
            $transportCount += $trip->transports()->count();
        }
        
        $tripRevenue = 5000;
        $activityRevenue = 2000;
        $commissionRevenue = 1000;
        $totalRevenue = $tripRevenue + $activityRevenue + $commissionRevenue;
        
        $tripRevenuePercent = ($totalRevenue > 0) ? ($tripRevenue / $totalRevenue * 100) : 0;
        $activityRevenuePercent = ($totalRevenue > 0) ? ($activityRevenue / $totalRevenue * 100) : 0;
        $commissionRevenuePercent = ($totalRevenue > 0) ? ($commissionRevenue / $totalRevenue * 100) : 0;
        
        $tripGrowth = 12;
        $revenueGrowth = 8;
        $collaborationRate = 75;
        $pendingRequests = 5;
        
        $currency = '$';
        
        $paidTravellersCount = Traveller::where('payment_status', 'paid')->count();
        $pendingTravellersCount = Traveller::where('payment_status', 'pending')->count();
        
        return view('manager.dashboard', compact(
            'totalTrips', 'activeTrips', 'upcomingTrips', 
            'totalTravellers', 'averageTravellers', 'nextTripDays',
            'travellers', 'hotelCount', 'guideCount', 'transportCount',
            'tripRevenue', 'activityRevenue', 'commissionRevenue', 'totalRevenue',
            'tripRevenuePercent', 'activityRevenuePercent', 'commissionRevenuePercent',
            'tripGrowth', 'revenueGrowth', 'collaborationRate', 'pendingRequests',
            'currency', 'paidTravellersCount', 'pendingTravellersCount'
        ));
    }

    /**
     * Add activity to trip
     */
    public function addActivity(Request $request, Trip $trip)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $activity = new Activity([
            'name' => $request->name,
            'location' => $request->location,
            'scheduled_at' => $request->scheduled_at,
            'description' => $request->description,
        ]);

        $trip->activities()->save($activity);

        return redirect()->back()->with('success', 'Activity added successfully!');
    }

    /**
     * Display the trip management page for managers
     */
    public function trips()
    {
        // Load all trips instead of filtering by manager
        $trips = Trip::with(['travellers', 'guides', 'hotels', 'transports'])
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
        $hotels = Hotel::with('user')->get();
        $guides = Guide::with('user')->get();
        $transports = Transport::with('user')->get();
        return view('manager.pages.collaborators', compact('hotels', 'guides', 'transports'));
    }

    /**
     * Display the manager's profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('manager.pages.profile', compact('user'));
    }

    /**
     * Show the form for editing the manager's profile
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('manager.pages.edit-profile', compact('user'));
    }

    /**
     * Update the manager's profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->hasFile('picture')) {
            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }
            $path = $request->file('picture')->store('profile_pictures', 'public');
            $user->picture = $path;
        }
        
        $user->save();
        return redirect()->route('manager.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the form for editing the manager's password
     */
    public function editPassword()
    {
        return view('manager.pages.edit-password');
    }

    /**
     * Update the manager's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        $user->password = $request->password;
        $user->save();
        
        return redirect()->route('manager.profile')->with('success', 'Password updated successfully!');
    }

    /**
     * Display all travellers
     */
    public function travellers(Request $request)
    {
        $filter = $request->input('filter', 'all');
        
        $query = Traveller::with(['user', 'trip']);
        
        if ($filter !== 'all') {
            $query->where('payment_status', $filter);
        }
        
        $travellers = $query->paginate(10);
        
        $totalTravellers = Traveller::count();
        $paidCount = Traveller::where('payment_status', 'paid')->count();
        $pendingCount = Traveller::where('payment_status', 'pending')->count();
        
        return view('manager.pages.travellers', compact(
            'travellers',
            'filter',
            'totalTravellers',
            'paidCount',
            'pendingCount'
        ));
    }

    /**
     * Confirm traveller payment
     */
    public function confirmTravellerPayment($id)
    {
        $traveller = Traveller::findOrFail($id);
        
        $traveller->payment_status = 'paid';
        $traveller->save();
        
        return redirect()->route('manager.travellers')
            ->with('success', 'Payment confirmed successfully');
    }

    /**
     * Display a traveller's details
     */
    public function viewTraveller($id)
    {
        $traveller = Traveller::with(['user', 'trip'])->findOrFail($id);
        return view('manager.pages.traveller-details', compact('traveller'));
    }

    /**
     * Cancel a traveller's trip
     */
    public function cancelTravellerTrip($id)
    {
        $traveller = Traveller::findOrFail($id);
        
        $traveller->payment_status = 'cancelled';
        $traveller->save();
        
        return redirect()->route('manager.travellers')
            ->with('success', 'Traveller\'s trip has been cancelled successfully');
    }
}

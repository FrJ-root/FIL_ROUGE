<?php

namespace App\Http\Controllers\Guide;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Guide;
use App\Models\Trip;

class GuideController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfile()
    {
        $guide = Auth::user()->guide;
        return view('guide.pages.profile', compact('guide'));
    }

    public function editProfile()
    {
        $guide = Auth::user()->guide;
        return view('guide.pages.edit-profile', compact('guide'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'preferred_locations' => 'required|string|max:500',
            'license_number' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
        ]);

        $guide = Auth::user()->guide;
        $guide->fill($request->only('license_number', 'specialization', 'preferred_locations'))->save();

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profile_pictures', 'public');
            Auth::user()->fill(['picture' => $path])->save();
        }

        return redirect()->route('guide.profile')->with('success', 'Profile updated successfully.');
    }

    public function showAvailability()
    {
        $guide = Auth::user()->guide;

        if (!$guide) {
            $guide = new Guide();
        }

        return view('guide.pages.availability', compact('guide'));
    }

    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability' => 'required|string|in:available,not available',
            'selected_dates' => 'nullable|string',
        ]);

        $guide = Auth::user()->guide;

        if (!$guide) {
            $guide = Guide::create([
                'user_id' => Auth::id(),
                'availability' => $request->availability,
                'selected_dates' => $request->selected_dates,
            ]);
        } else {
            $guide->update([
                'availability' => $request->availability,
                'selected_dates' => $request->selected_dates,
            ]);
        }

        return redirect()->route('guide.availability')
            ->with('success', 'Your availability has been updated successfully.');
    }

    public function showTravellers()
    {
        $guide = Auth::user()->guide;
        $travellers = $guide->trips()
            ->with('travellers.user')
            ->get()
            ->pluck('travellers')
            ->flatten();

        return view('guide.pages.travellers', compact('travellers'));
    }

    public function sendMessageToTraveller(Request $request)
    {
        $request->validate([
            'traveller_id' => 'required|exists:users,id',
            'message' => 'required|string|max:500',
        ]);

        DB::table('messages')->insert([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->traveller_id,
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Message sent successfully.');
    }

    public function showMessages()
    {
        $messages = DB::table('messages')
            ->where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guide.pages.messages', compact('messages'));
    }

    public function showReviews()
    {
        $guide = Auth::user()->guide;
        $reviews = $guide->reviews()->with('traveller.user')->latest()->get();
        return view('guide.pages.reviews', compact('reviews', 'guide'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'guide_id' => 'required|exists:guides,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'traveller_id' => Auth::user()->traveller->id,
            'guide_id' => $request->guide_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    public function availableTrips()
    {
        $guide = Auth::user()->guide;
        
        $assignedTripIds = $guide ? $guide->trips()->pluck('trips.id')->toArray() : [];
        
        $availableTrips = Trip::with(['guides', 'travellers', 'activities', 'itinerary'])
            ->orderBy('start_date')
            ->get();
        
        return view('guide.pages.available-trips', compact('availableTrips', 'assignedTripIds'));
    }

    public function showTripDetails($id)
    {
        $guide = Auth::user()->guide;
        $trip = Trip::with(['guides', 'travellers', 'activities', 'itinerary'])->findOrFail($id);
        
        $isAssigned = $guide ? $guide->trips()->where('trips.id', $id)->exists() : false;
        
        return view('guide.pages.trip-details', compact('trip', 'isAssigned'));
    }

    public function joinTrip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);
        
        $guide = Auth::user()->guide;
        
        if (!$guide) {
            return redirect()->back()->with('error', 'Guide profile not found');
        }
        
        if ($guide->trips()->where('trips.id', $request->trip_id)->exists()) {
            return redirect()->back()->with('info', 'You are already assigned to this trip');
        }
        
        $guide->trips()->attach($request->trip_id);
        
        return redirect()->route('guide.trips')->with('success', 'Successfully joined the trip');
    }

    public function withdrawFromTrip($id)
    {
        $guide = Auth::user()->guide;
        
        if (!$guide) {
            return redirect()->back()->with('error', 'Guide profile not found');
        }
        
        $guide->trips()->detach($id);
        
        return redirect()->route('guide.trips')->with('success', 'Successfully withdrawn from the trip');
    }
}
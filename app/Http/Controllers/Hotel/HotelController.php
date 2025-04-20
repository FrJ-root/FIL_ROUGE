<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\Review;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showProfile()
    {
        $hotel = Auth::user()->hotels;
        
        $totalRooms = 0;
        $availableRooms = 0;
        $bookedRooms = 0;
        
        if ($hotel) {
            $rooms = $hotel->rooms;
            $totalRooms = $rooms->count();
            $availableRooms = $rooms->where('is_available', true)->count();
            $bookedRooms = $totalRooms - $availableRooms;
        }
        
        return view('hotel.pages.profile', compact('hotel', 'totalRooms', 'availableRooms', 'bookedRooms'));
    }
    
    public function editProfile()
    {
        $hotel = Auth::user()->hotels;
        return view('hotel.pages.edit-profile', compact('hotel'));
    }
    
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|array',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);
        
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        $amenities = $request->amenities ? json_encode($request->amenities) : null;
        
        $hotel->update([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'star_rating' => $request->star_rating,
            'price_per_night' => $request->price_per_night,
            'amenities' => $amenities,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hotels', 'public');
            $hotel->update(['image' => $path]);
        }
        
        return redirect()->route('hotel.profile')
            ->with('success', 'Hotel profile updated successfully');
    }
    
    public function createProfile()
    {
        if (Auth::user()->hotels) {
            return redirect()->route('hotel.profile.edit')
                ->with('info', 'You already have a hotel profile. You can edit it here.');
        }
        
        return view('hotel.pages.create-profile');
    }
    
    public function storeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|array',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);
        
        $path = $request->file('image')->store('hotels', 'public');
        $amenities = $request->amenities ? json_encode($request->amenities) : null;
        
        $hotel = Hotel::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'star_rating' => $request->star_rating,
            'price_per_night' => $request->price_per_night,
            'image' => $path,
            'amenities' => $amenities,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        
        return redirect()->route('hotel.profile')
            ->with('success', 'Hotel profile created successfully');
    }
    
    public function showRooms()
    {
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        $rooms = $hotel->rooms()->paginate(10);
        return view('hotel.pages.rooms', compact('rooms'));
    }
    
    public function createRoom()
    {
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        $roomTypes = RoomType::all();
        
        if ($roomTypes->isEmpty()) {
            // Create default room types if none exist
            $defaultTypes = [
                ['name' => 'Standard', 'description' => 'Standard room with basic amenities'],
                ['name' => 'Deluxe', 'description' => 'Deluxe room with premium amenities'],
                ['name' => 'Suite', 'description' => 'Spacious suite with separate living area'],
                ['name' => 'Family', 'description' => 'Large room suitable for families']
            ];
            
            foreach ($defaultTypes as $type) {
                RoomType::create($type);
            }
            
            $roomTypes = RoomType::all();
        }
        
        return view('hotel.pages.create-room', compact('roomTypes'));
    }
    
    public function storeRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean',
        ]);
        
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        // Check if room number is already used in this hotel
        if ($request->filled('room_number')) {
            $existingRoom = Room::where('hotel_id', $hotel->id)
                               ->where('room_number', $request->room_number)
                               ->first();
            
            if ($existingRoom) {
                return back()->withInput()->withErrors([
                    'room_number' => 'This room number is already in use for your hotel.'
                ]);
            }
        }
        
        $room = new Room([
            'name' => $request->name,
            'room_type_id' => $request->room_type_id,
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'price_per_night' => $request->price_per_night,
            'is_available' => $request->has('is_available') ? true : true, // Default to available
        ]);
        
        $hotel->rooms()->save($room);
        
        return redirect()->route('hotel.rooms')
            ->with('success', 'Room added successfully');
    }
    
    public function editRoom(Room $room)
    {
        $hotel = Auth::user()->hotels;
        
        // Check if the room belongs to this hotel
        if ($room->hotel_id != $hotel->id) {
            return redirect()->route('hotel.rooms')
                ->with('error', 'You are not authorized to edit this room.');
        }
        
        $roomTypes = RoomType::all();
        return view('hotel.pages.edit-room', compact('room', 'roomTypes'));
    }
    
    public function updateRoom(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
        ]);
        
        $hotel = Auth::user()->hotels;
        
        // Check if the room belongs to this hotel
        if ($room->hotel_id != $hotel->id) {
            return redirect()->route('hotel.rooms')
                ->with('error', 'You are not authorized to update this room.');
        }
        
        $room->update([
            'name' => $request->name,
            'room_type_id' => $request->room_type_id,
            'capacity' => $request->capacity,
            'price_per_night' => $request->price_per_night,
        ]);
        
        return redirect()->route('hotel.rooms')
            ->with('success', 'Room updated successfully');
    }
    
    public function destroyRoom(Room $room)
    {
        $hotel = Auth::user()->hotels;
        
        // Check if the room belongs to this hotel
        if ($room->hotel_id != $hotel->id) {
            return redirect()->route('hotel.rooms')
                ->with('error', 'You are not authorized to delete this room.');
        }
        
        $room->delete();
        
        return redirect()->route('hotel.rooms')
            ->with('success', 'Room deleted successfully');
    }
    
    public function showBookings()
    {
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        $bookings = Booking::whereHas('room', function($query) use ($hotel) {
            $query->where('hotel_id', $hotel->id);
        })->with(['user', 'room'])->paginate(10);
        
        return view('hotel.pages.bookings', compact('bookings'));
    }
    
    public function showBookingDetails(Booking $booking)
    {
        $hotel = Auth::user()->hotels;
        
        // Check if the booking is for a room in this hotel
        $isValidBooking = $booking->room->hotel_id === $hotel->id;
        
        if (!$isValidBooking) {
            return redirect()->route('hotel.bookings')
                ->with('error', 'You are not authorized to view this booking.');
        }
        
        return view('hotel.pages.booking-details', compact('booking'));
    }
    
    public function confirmBooking(Booking $booking)
    {
        $hotel = Auth::user()->hotels;
        
        // Check if the booking is for a room in this hotel
        $isValidBooking = $booking->room->hotel_id === $hotel->id;
        
        if (!$isValidBooking) {
            return redirect()->route('hotel.bookings')
                ->with('error', 'You are not authorized to modify this booking.');
        }
        
        $booking->update(['status' => 'confirmed']);
        
        return redirect()->route('hotel.bookings')
            ->with('success', 'Booking confirmed successfully');
    }
    
    public function cancelBooking(Booking $booking)
    {
        $hotel = Auth::user()->hotels;
        
        // Check if the booking is for a room in this hotel
        $isValidBooking = $booking->room->hotel_id === $hotel->id;
        
        if (!$isValidBooking) {
            return redirect()->route('hotel.bookings')
                ->with('error', 'You are not authorized to modify this booking.');
        }
        
        $booking->update(['status' => 'cancelled']);
        
        return redirect()->route('hotel.bookings')
            ->with('success', 'Booking cancelled successfully');
    }
    
    public function showReviews()
    {
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        $reviews = $hotel->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);
            
        return view('hotel.pages.reviews', compact('reviews'));
    }
    
    public function showSettings()
    {
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        return view('hotel.pages.settings', compact('hotel'));
    }
    
    public function showAvailability()
    {
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        return view('hotel.pages.availability', compact('hotel'));
    }
    
    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability' => 'required|string|in:available,not available',
            'selected_dates' => 'nullable|string',
            'available_rooms' => 'nullable|integer|min:0',
        ]);
        
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->route('hotel.profile.create')
                ->with('error', 'Please create your hotel profile first.');
        }
        
        try {
            $hotel->update([
                'availability' => $request->availability,
                'selected_dates' => $request->selected_dates,
                'available_rooms' => $request->available_rooms ?? 0,
            ]);
            
            return redirect()->route('hotel.availability')
                ->with('success', 'Availability updated successfully');
        } catch (\Exception $e) {
            // Check if the error is about missing columns
            if (strpos($e->getMessage(), "Column not found") !== false) {
                return redirect()->route('hotel.availability')
                    ->with('error', 'Database columns are missing. Please run the migration: php artisan migrate');
            }
            
            return redirect()->route('hotel.availability')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    public function showTrips()
    {
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return view('hotel.pages.trips', ['trips' => collect()]);
        }
        
        $trips = $hotel->trips()->with('guides', 'travellers')->get();
        return view('hotel.pages.trips', compact('trips'));
    }
    
    public function showTripDetails($id)
    {
        $hotel = Auth::user()->hotels;
        $trip = Trip::with(['guides', 'travellers', 'activities', 'itinerary'])->findOrFail($id);
        
        // Check if hotel is assigned to this trip
        $isAssigned = $hotel ? $hotel->trips()->where('trips.id', $id)->exists() : false;
        
        return view('hotel.pages.trip-details', compact('trip', 'isAssigned'));
    }
    
    public function availableTrips()
    {
        $hotel = Auth::user()->hotels;
        
        // Get IDs of trips that the hotel is already assigned to
        $assignedTripIds = $hotel ? $hotel->trips()->pluck('trips.id')->toArray() : [];
        
        // Get all trips with relationships
        $availableTrips = Trip::with(['guides', 'travellers', 'activities', 'itinerary'])
            ->orderBy('start_date')
            ->get();
        
        return view('hotel.pages.available-trips', compact('availableTrips', 'assignedTripIds'));
    }
    
    public function joinTrip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);
        
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->back()->with('error', 'Hotel profile not found');
        }
        
        // Check if already assigned to this trip
        if ($hotel->trips()->where('trips.id', $request->trip_id)->exists()) {
            return redirect()->back()->with('info', 'You are already assigned to this trip');
        }
        
        // Assign hotel to trip
        $hotel->trips()->attach($request->trip_id);
        
        return redirect()->route('hotel.trips')->with('success', 'Successfully joined the trip');
    }
    
    public function withdrawFromTrip($id)
    {
        $hotel = Auth::user()->hotels;
        
        if (!$hotel) {
            return redirect()->back()->with('error', 'Hotel profile not found');
        }
        
        // Remove hotel from trip
        $hotel->trips()->detach($id);
        
        return redirect()->route('hotel.trips')->with('success', 'Successfully withdrawn from the trip');
    }
    
    public function dashboard()
    {
        $hotel = Auth::user()->hotels;
        
        // Default empty values
        $rooms = collect();
        $availableRooms = 0;
        $bookedRooms = 0;
        $recentBookings = collect();
        $recentReviews = collect();
        $upcomingCheckins = collect();
        
        if ($hotel) {
            // Get room statistics
            $rooms = $hotel->rooms;
            $availableRooms = $rooms->where('is_available', true)->count();
            $bookedRooms = $rooms->count() - $availableRooms;
            
            // Get recent bookings
            $recentBookings = Booking::whereHas('room', function($query) use ($hotel) {
                $query->where('hotel_id', $hotel->id);
            })->with(['user', 'room'])->latest()->take(5)->get();
            
            // Get recent reviews
            $recentReviews = Review::where('hotel_id', $hotel->id)
                ->with('traveller.user')
                ->latest()
                ->take(3)
                ->get();
            
            // Get upcoming check-ins
            $upcomingCheckins = Booking::whereHas('room', function($query) use ($hotel) {
                $query->where('hotel_id', $hotel->id);
            })->where('check_in', '>=', now())
                ->where('status', 'confirmed')
                ->with(['user', 'room'])
                ->orderBy('check_in')
                ->take(5)
                ->get();
        }
        
        return view('hotel.dashboard', compact(
            'hotel', 
            'rooms', 
            'availableRooms', 
            'bookedRooms', 
            'recentBookings', 
            'recentReviews', 
            'upcomingCheckins'
        ));
    }
}
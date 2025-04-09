<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::query();
        
        // Handle destination filter
        if ($request->filled('destination')) {
            $query->where('city', 'like', "%{$request->destination}%")
                  ->orWhere('name', 'like', "%{$request->destination}%");
        }
        
        // Handle star rating filter
        if ($request->filled('rating')) {
            $query->where('star_rating', $request->rating);
        }
        
        // Handle price range filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price_per_night', [$request->min_price, $request->max_price]);
        }
        
        // Handle sorting
        $sortBy = $request->get('sort_by', 'price_asc');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price_per_night', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'rating':
                $query->orderBy('star_rating', 'desc');
                break;
            default:
                $query->orderBy('price_per_night', 'asc');
        }
        
        // Get all cities for the filter
        $cities = Hotel::select('city')->distinct()->get();
        
        // Paginate the results
        $hotels = $query->paginate(9);
        
        return view('hotels.index', compact('hotels', 'cities', 'sortBy'));
    }
    
    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        $rooms = Room::where('hotel_id', $id)->get();
        
        return view('hotels.show', compact('hotel', 'rooms'));
    }
    
    public function book(Request $request, $id)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'room_id' => 'required|exists:rooms,id',
            'guests' => 'required|integer|min:1'
        ]);
        
        $room = Room::findOrFail($request->room_id);
        
        // Calculate total price
        $checkIn = new \DateTime($request->check_in);
        $checkOut = new \DateTime($request->check_out);
        $days = $checkIn->diff($checkOut)->days;
        $totalPrice = $room->price_per_night * $days;
        
        // Create booking
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->hotel_id = $id;
        $booking->room_id = $request->room_id;
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->guests = $request->guests;
        $booking->total_price = $totalPrice;
        $booking->status = 'pending';
        $booking->save();
        
        return redirect()->route('hotels.booking.confirmation', $booking->id)
            ->with('success', 'Your booking request has been received!');
    }
}

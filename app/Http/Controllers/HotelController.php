<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    /**
     * Constructor with automatic role assignment
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && $request->is('hotel/*')) {
                $user = Auth::user();
                
                // Check if the user owns a hotel
                $ownsHotel = Hotel::where('user_id', $user->id)->exists();
                
                // Use Spatie's hasRole method correctly
                if ($ownsHotel && !$user->hasRole('hotel')) {
                    // Use Spatie's assignRole method or our custom one
                    $user->assignRole('hotel');
                }
            }
            
            return $next($request);
        });
    }
    
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

    public function verifyHotelRole()
    {
        $user = Auth::user();
        
        // Check if user has hotel role
        $hasHotelRole = DB::table('role_user')
            ->where('user_id', $user->id)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('roles')
                    ->whereRaw('roles.id = role_user.role_id')
                    ->where('roles.name', 'hotel');
            })
            ->exists();
            
        if (!$hasHotelRole) {
            // Assign hotel role if the user doesn't have it
            $hotelRoleId = DB::table('roles')->where('name', 'hotel')->first()->id ?? null;
            
            if ($hotelRoleId) {
                DB::table('role_user')->insert([
                    'user_id' => $user->id,
                    'role_id' => $hotelRoleId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                return redirect()->route('hotel.dashboard')
                    ->with('success', 'Hotel role has been assigned to your account');
            }
        }
        
        return redirect()->route('hotel.dashboard');
    }
    
    /**
     * Display hotel dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // If user doesn't have hotel role but owns a hotel, assign the role
        // Use Spatie's hasRole method
        if (!$user->hasRole('hotel')) {
            $ownsHotel = Hotel::where('user_id', $user->id)->exists();
            
            if ($ownsHotel) {
                // Use Spatie's assignRole method
                $user->assignRole('hotel');
            }
        }
        
        // Get the user's hotels
        $hotels = Hotel::where('user_id', $user->id)->get();
        
        return view('hotel.dashboard', compact('hotels'));
    }
    
    /**
     * Create a new hotel
     */
    public function create()
    {
        return view('hotel.create');
    }
    
    /**
     * Store a new hotel
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'star_rating' => 'required|integer|between:1,5',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'amenities' => 'required|array',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        
        $hotel = new Hotel($request->except('image'));
        $hotel->user_id = Auth::id();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
            $hotel->image = $imagePath;
        }
        
        $hotel->save();
        
        // Assign hotel role to the user
        Auth::user()->assignRole('hotel');
        
        return redirect()->route('hotel.dashboard')
            ->with('success', 'Hotel created successfully.');
    }
}

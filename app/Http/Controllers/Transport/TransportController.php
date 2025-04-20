<?php

namespace App\Http\Controllers\Transport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Trip;

class TransportController extends Controller
{
    public function showProfile()
    {
        $transport = Auth::user()->transports; // Using the correct relationship name
        return view('transport.pages.profile', compact('transport'));
    }

    public function editProfile()
    {
        $transport = Auth::user()->transports;
        return view('transport.pages.edit-profile', compact('transport'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'transport_type' => 'required|string|in:Tourist vehicle,Plane,Train,Horse,Camel,Bus',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $transport = Auth::user()->transports;
        
        if (!$transport) {
            return redirect()->route('transport.profile')->with('error', 'Transport profile not found');
        }

        $transport->fill($request->only([
            'company_name', 
            'license_number', 
            'transport_type', 
            'address', 
            'phone'
        ]))->save();

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profile_pictures', 'public');
            Auth::user()->update(['picture' => $path]);
        }

        return redirect()->route('transport.profile')->with('success', 'Profile updated successfully');
    }

    public function showTrips()
    {
        $transport = Auth::user()->transports;
        
        if (!$transport) {
            return view('transport.pages.trips', ['trips' => collect()]);
        }
        
        $trips = $transport->trips()->with('guides', 'travellers')->get();
        return view('transport.pages.trips', compact('trips'));
    }

    public function showTripDetails($id)
    {
        $transport = Auth::user()->transports;
        $trip = Trip::with(['guides', 'travellers', 'activities', 'itinerary'])->findOrFail($id);
        
        // Check if transport is assigned to this trip
        $isAssigned = $transport ? $transport->trips()->where('trips.id', $id)->exists() : false;
        
        return view('transport.pages.trip-details', compact('trip', 'isAssigned'));
    }
    
    public function availableTrips()
    {
        $transport = Auth::user()->transports;
        
        // Get IDs of trips that the transport is already assigned to
        $assignedTripIds = $transport ? $transport->trips()->pluck('trips.id')->toArray() : [];
        
        // Get all trips with relationships
        $availableTrips = Trip::with(['guides', 'travellers', 'activities', 'itinerary'])
            ->orderBy('start_date')
            ->get();
        
        // Change the view name to match your actual file
        return view('transport.pages.availability', compact('availableTrips', 'assignedTripIds'));
    }

    public function joinTrip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);
        $transport = Auth::user()->transports;
        if (!$transport) {
            return redirect()->back()->with('error', 'Transport profile not found');
        }
        // Check if already assigned to this trip
        if ($transport->trips()->where('trips.id', $request->trip_id)->exists()) {
            return redirect()->back()->with('info', 'You are already assigned to this trip');
        }
        // Assign transport to trip
        $transport->trips()->attach($request->trip_id);
        return redirect()->route('transport.trips')->with('success', 'Successfully joined the trip');
    }

    public function withdrawFromTrip($id)
    {
        $transport = Auth::user()->transports;
        if (!$transport) {
            return redirect()->back()->with('error', 'Transport profile not found');
        }
        // Remove transport from trip
        $transport->trips()->detach($id);
        return redirect()->route('transport.trips')->with('success', 'Successfully withdrawn from the trip');
    }

    public function showAvailability()
    {
        $transport = Auth::user()->transports;
        return view('transport.pages.availability', compact('transport'));
    }

    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability' => 'required|string|in:available,not available',
            'selected_dates' => 'nullable|string',
            'service_areas' => 'nullable|array',
            'service_areas.*' => 'string',
            'vehicle_capacity' => 'nullable|string',
        ]);

        $transport = Auth::user()->transports;
        
        if (!$transport) {
            return redirect()->back()->with('error', 'Transport profile not found');
        }

        $transport->update([
            'availability' => $request->availability,
            'selected_dates' => $request->selected_dates,
            'service_areas' => is_array($request->service_areas) ? implode(',', $request->service_areas) : null,
            'vehicle_capacity' => $request->vehicle_capacity,
        ]);

        return redirect()->route('transport.availability')->with('success', 'Availability updated successfully');
    }
}
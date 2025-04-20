@extends('hotel.layouts.hotel')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-search text-hotel-blue mr-3"></i>
        Available Trips
    </h1>
    <a href="{{ route('hotel.trips') }}" class="flex items-center text-hotel-blue hover:underline">
        <i class="fas fa-arrow-left mr-2"></i> Back to Your Trips
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            <p>{{ session('info') }}</p>
        </div>
    </div>
@endif

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    @if(isset($availableTrips) && count($availableTrips) > 0)
        <div class="bg-gray-50 p-4 border-b">
            <div class="flex items-center space-x-2">
                <i class="fas fa-info-circle text-hotel-blue"></i>
                <p class="text-gray-700">Below are trips that require accommodation services. Click on a trip to view details or join.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($availableTrips as $trip)
                <div class="bg-white border rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <div class="h-40 bg-gray-200 relative">
                        @php
                            $coverImageUrl = null;
                            if ($trip->cover_picture) {
                                $coverImageUrl = asset('storage/images/trip/' . $trip->cover_picture);
                            } else {
                                // Fallback image
                                $coverImageUrl = 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
                            }
                        @endphp
                        <img src="{{ $coverImageUrl }}" alt="{{ $trip->destination }}" class="w-full h-full object-cover">
                        <div class="absolute top-0 right-0 p-2">
                            @php
                                $isAssigned = in_array($trip->id, $assignedTripIds);
                            @endphp
                            @if($isAssigned)
                                <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">Joined</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $trip->destination }}</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ date('M d, Y', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}
                        </p>
                        <p class="text-sm text-gray-700 mb-3">
                            <span class="font-medium">{{ $trip->travellers->count() }}</span> travellers · 
                            <span class="font-medium">{{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }}</span> days
                        </p>
                        
                        <div class="flex space-x-2 mt-4">
                            <a href="{{ route('hotel.trip.details', $trip->id) }}" class="flex-1 bg-hotel-blue hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition-colors">
                                View Details
                            </a>
                            @if(!$isAssigned)
                                <form action="{{ route('hotel.join-trip') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                    <button type="submit" class="w-full bg-hotel-green hover:bg-green-600 text-white py-2 px-4 rounded-lg transition-colors">
                                        Join Trip
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('hotel.withdraw-trip', $trip->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition-colors">
                                        Leave Trip
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-route text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-bold text-gray-600 mb-2">No Available Trips</h3>
            <p class="text-gray-500">There are currently no trips available for accommodation providers.</p>
        </div>
    @endif
</div>
@endsection

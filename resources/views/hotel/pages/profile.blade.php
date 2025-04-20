@extends('hotel.layouts.hotel')

@section('content')
<h1 class="text-2xl font-bold mb-6">Hotel Profile</h1>
<div class="bg-white shadow rounded-xl p-6">
    @if(isset($hotel) && $hotel)
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/3 mb-6 md:mb-0 md:pr-8">
                <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/default-hotel.jpg') }}" 
                     alt="{{ $hotel->name }}" 
                     class="w-full h-auto rounded-lg shadow-md mb-4">
                
                <div class="flex items-center mt-4 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $hotel->star_rating ? 'text-yellow-400' : 'text-gray-300' }} mr-1"></i>
                    @endfor
                    <span class="text-sm text-gray-600 ml-2">{{ $hotel->star_rating }}-Star Hotel</span>
                </div>
                
                <div class="mt-4">
                    <h3 class="font-semibold text-gray-700 mb-2">Location</h3>
                    <p class="text-gray-600 flex items-start">
                        <i class="fas fa-map-marker-alt text-red-500 mr-2 mt-1"></i>
                        {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}
                    </p>
                </div>
            </div>
            
            <div class="md:w-2/3">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-800">{{ $hotel->name }}</h2>
                    <a href="{{ route('hotel.profile.edit') }}" class="bg-hotel-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-1"></i> Edit Profile
                    </a>
                </div>
                
                <p class="text-gray-600 mb-6">{{ $hotel->description }}</p>
                
                <h3 class="font-semibold text-gray-700 mb-2">Amenities</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                    @if(is_array($hotel->amenities))
                        @foreach($hotel->amenities as $amenity)
                            <div class="flex items-center">
                                <i class="fas fa-check text-hotel-green mr-2"></i>
                                <span class="text-gray-600">{{ $amenity }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                <h3 class="font-semibold text-gray-700 mb-2">Current Pricing</h3>
                <p class="text-gray-600">Starting at <span class="text-hotel-blue font-semibold">${{ number_format($hotel->price_per_night, 2) }}</span> per night</p>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-700 mb-2">Room Statistics</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-gray-500 text-sm">Total Rooms</div>
                            <div class="text-xl font-bold text-gray-800">{{ $totalRooms ?? 0 }}</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-gray-500 text-sm">Available Rooms</div>
                            <div class="text-xl font-bold text-green-600">{{ $availableRooms ?? 0 }}</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-gray-500 text-sm">Booked Rooms</div>
                            <div class="text-xl font-bold text-red-500">{{ $bookedRooms ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <i class="fas fa-hotel text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-bold text-gray-600 mb-2">No Hotel Profile Found</h3>
            <p class="text-gray-500 mb-6">You haven't set up your hotel profile yet.</p>
            <a href="{{ route('hotel.profile.create') }}" class="bg-hotel-blue text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus-circle mr-1"></i> Create Hotel Profile
            </a>
        </div>
    @endif
</div>
@endsection

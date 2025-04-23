@extends('traveller.layouts.master')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="mt-2 opacity-90">Ready for your next adventure?</p>
            </div>
            <div class="bg-white/20 p-4 rounded-full">
                <i class="fas fa-plane-departure text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
    <i class="fas fa-tachometer-alt mr-2 text-blue-500"></i>
    Quick Actions
</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('traveller.pages.profile') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-blue-500/10 text-blue-500 p-4 rounded-lg mr-4 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-user-edit text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-blue-500 transition-colors duration-300">My Profile</h3>
                <p class="text-gray-600 text-sm mt-1">View and update your details</p>
            </div>
        </div>
    </a>

    <a href="{{ route('traveller.trips') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-green-500/10 text-green-500 p-4 rounded-lg mr-4 group-hover:bg-green-500 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-suitcase text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-green-500 transition-colors duration-300">My Trips</h3>
                <p class="text-gray-600 text-sm mt-1">View your booked experiences</p>
            </div>
        </div>
    </a>

    <a href="#" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-purple-500/10 text-purple-500 p-4 rounded-lg mr-4 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-compass text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-purple-500 transition-colors duration-300">Explore</h3>
                <p class="text-gray-600 text-sm mt-1">Discover new destinations</p>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-blue-500 text-white px-6 py-4 flex items-center">
            <i class="fas fa-calendar-alt mr-2"></i>
            <h3 class="font-bold">Your Upcoming Trips</h3>
        </div>
        <div class="p-6">
            @if(isset($upcomingTrips) && count($upcomingTrips) > 0)
                <div class="space-y-4">
                    @foreach($upcomingTrips as $trip)
                        <div class="flex items-center p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0 h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt text-indigo-500"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $trip->destination }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} - 
                                    {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                            <div>
                                <a href="#" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-8">
                    <i class="fas fa-plane text-4xl text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">No upcoming trips scheduled</h4>
                    <p class="text-sm text-gray-400 mt-1">Time to plan your next adventure!</p>
                    <a href="#" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Browse Destinations
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-green-500 text-white px-6 py-4 flex items-center">
            <i class="fas fa-chart-line mr-2"></i>
            <h3 class="font-bold">Your Travel Stats</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl font-bold text-indigo-600">{{ isset($pastTrips) ? count($pastTrips) : 0 }}</div>
                    <div class="text-sm text-gray-500">Trips Completed</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600">{{ isset($upcomingTrips) ? count($upcomingTrips) : 0 }}</div>
                    <div class="text-sm text-gray-500">Upcoming Trips</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600">{{ rand(2, 5) }}</div>
                    <div class="text-sm text-gray-500">Countries Visited</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl font-bold text-purple-600">{{ rand(50, 500) }}</div>
                    <div class="text-sm text-gray-500">Travel Points</div>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <h4 class="text-sm font-medium text-gray-500 mb-2">YOUR TRAVEL PREFERENCES</h4>
                <div class="flex flex-wrap gap-2">
                    @php
                        $interests = ['Beach', 'Mountain', 'City', 'Cultural', 'Adventure', 'Food', 'Wildlife', 'Relaxation'];
                        $colors = ['blue', 'green', 'indigo', 'purple', 'red', 'yellow', 'pink', 'teal'];
                        $selectedInterests = array_slice($interests, 0, rand(3, 6));
                    @endphp
                    
                    @foreach($selectedInterests as $index => $interest)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $colors[$index % count($colors)] }}-100 text-{{ $colors[$index % count($colors)] }}-800">
                            {{ $interest }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden">
    <div class="bg-purple-500 text-white px-6 py-4 flex items-center">
        <i class="fas fa-lightbulb mr-2"></i>
        <h3 class="font-bold">Travel Inspiration</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $destinations = [
                    ['name' => 'Marrakech', 'image' => 'https://images.unsplash.com/photo-1597211684565-dca64d72bdfe', 'country' => 'Morocco'],
                    ['name' => 'Paris', 'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34', 'country' => 'France'],
                    ['name' => 'Bali', 'image' => 'https://images.unsplash.com/photo-1539367628448-4bc5c9d171c8', 'country' => 'Indonesia'],
                ];
            @endphp
            
            @foreach($destinations as $destination)
                <div class="relative rounded-lg overflow-hidden group hover-lift">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ $destination['image'] }}?w=500&auto=format" alt="{{ $destination['name'] }}" 
                            class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex flex-col justify-end p-4">
                        <h3 class="text-white font-bold">{{ $destination['name'] }}</h3>
                        <p class="text-white/80 text-sm">{{ $destination['country'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 text-center">
            <a href="#" class="text-blue-500 hover:text-blue-700 font-medium flex items-center justify-center">
                Explore more destinations 
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.grid > a, .grid > div');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `all 0.5s ease ${index * 0.1}s`;
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    });
</script>
@endpush
@endsection
@extends('hotel.layouts.hotel')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-hotel-blue to-blue-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="mt-2 opacity-90">{{ isset($hotel) && $hotel ? $hotel->name : 'Manage your hotel with ease' }}</p>
            </div>
            <div class="bg-white/20 p-4 rounded-full">
                <i class="fas fa-hotel text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
    <i class="fas fa-tachometer-alt mr-2 text-hotel-blue"></i>
    Quick Actions
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('hotel.profile') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-hotel-blue/10 text-hotel-blue p-4 rounded-lg mr-4 group-hover:bg-hotel-blue group-hover:text-white transition-colors duration-300">
                <i class="fas fa-hotel text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-hotel-blue transition-colors duration-300">Hotel Profile</h3>
                <p class="text-gray-600 text-sm mt-1">Manage hotel details</p>
            </div>
        </div>
    </a>

    <a href="{{ route('hotel.rooms') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-hotel-green/10 text-hotel-green p-4 rounded-lg mr-4 group-hover:bg-hotel-green group-hover:text-white transition-colors duration-300">
                <i class="fas fa-door-open text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-hotel-green transition-colors duration-300">Rooms</h3>
                <p class="text-gray-600 text-sm mt-1">Manage your rooms</p>
            </div>
        </div>
    </a>

    <a href="{{ route('hotel.availability') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-amber-500/10 text-amber-500 p-4 rounded-lg mr-4 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-amber-500 transition-colors duration-300">Availability</h3>
                <p class="text-gray-600 text-sm mt-1">Set your availability</p>
            </div>
        </div>
    </a>

    <a href="{{ route('hotel.bookings') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-purple-500/10 text-purple-500 p-4 rounded-lg mr-4 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300">
                <i class="fas fa-concierge-bell text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-purple-500 transition-colors duration-300">Bookings</h3>
                <p class="text-gray-600 text-sm mt-1">Manage reservations</p>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-hotel-blue text-white px-6 py-4">
            <h3 class="font-bold flex items-center">
                <i class="fas fa-chart-pie mr-2"></i> Room Availability
            </h3>
        </div>
        <div class="p-6">
            @if(isset($rooms) && count($rooms) > 0)
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-hotel-blue">{{ $availableRooms }}</div>
                        <div class="text-gray-600 text-sm mt-1">Available</div>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-red-500">{{ $bookedRooms }}</div>
                        <div class="text-gray-600 text-sm mt-1">Booked</div>
                    </div>
                </div>
                
                <div class="mt-4 h-48">
                    <canvas id="availabilityChart"></canvas>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-door-closed text-4xl text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">No rooms found</h4>
                    <p class="text-sm text-gray-400 mt-1">Add rooms to see availability stats</p>
                    <a href="{{ route('hotel.rooms.create') }}" class="mt-3 inline-block bg-hotel-blue text-white px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-plus mr-1"></i> Add Room
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden lg:col-span-2">
        <div class="bg-hotel-green text-white px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i> Recent Bookings
            </h3>
            <a href="{{ route('hotel.bookings') }}" class="text-xs bg-white text-hotel-green px-2 py-1 rounded-full hover:bg-gray-100 transition-colors">
                View All
            </a>
        </div>
        <div class="p-4">
            @if(isset($recentBookings) && count($recentBookings) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentBookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                {{ strtoupper(substr($booking->user->name ?? 'G', 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $booking->user->name ?? 'Guest' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->room->name ?? 'Unknown Room' }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->check_in ? date('M d', strtotime($booking->check_in)) : 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->check_out ? 'to ' . date('M d, Y', strtotime($booking->check_out)) : '' }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($booking->status == 'confirmed')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmed
                                            </span>
                                        @elseif($booking->status == 'pending')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $booking->status ?? 'Unknown' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">No recent bookings</h4>
                    <p class="text-sm text-gray-400 mt-1">New bookings will appear here</p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-amber-500 text-white px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold flex items-center">
                <i class="fas fa-star mr-2"></i> Recent Reviews
            </h3>
            <a href="{{ route('hotel.reviews') }}" class="text-xs bg-white text-amber-500 px-2 py-1 rounded-full hover:bg-gray-100 transition-colors">
                View All
            </a>
        </div>
        <div class="p-6">
            @if(isset($recentReviews) && count($recentReviews) > 0)
                <div class="space-y-4">
                    @foreach($recentReviews as $review)
                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex justify-between">
                                <div class="font-medium">{{ $review->traveller->user->name ?? 'Guest' }}</div>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mt-1">{{ Str::limit($review->comment, 100) }}</p>
                            <div class="text-xs text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="far fa-star text-4xl text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">No reviews yet</h4>
                    <p class="text-sm text-gray-400 mt-1">Reviews will appear here when guests leave them</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-purple-500 text-white px-6 py-4">
            <h3 class="font-bold flex items-center">
                <i class="fas fa-door-open mr-2"></i> Upcoming Check-ins
            </h3>
        </div>
        <div class="p-6">
            @if(isset($upcomingCheckins) && count($upcomingCheckins) > 0)
                <div class="space-y-4">
                    @foreach($upcomingCheckins as $checkin)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center">
                                <div class="bg-purple-100 text-purple-500 rounded-full h-10 w-10 flex items-center justify-center mr-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $checkin->user->name ?? 'Guest' }}</div>
                                    <div class="text-sm text-gray-500">Room: {{ $checkin->room->name ?? 'Unknown Room' }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-medium text-hotel-blue">{{ $checkin->check_in ? date('M d, Y', strtotime($checkin->check_in)) : 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $checkin->check_in ? \Carbon\Carbon::parse($checkin->check_in)->diffForHumans() : '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">No upcoming check-ins</h4>
                    <p class="text-sm text-gray-400 mt-1">New guest arrivals will appear here</p>
                </div>
            @endif
        </div>
    </div>
</div>

@if(isset($rooms) && count($rooms) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('availabilityChart').getContext('2d');
        const availabilityChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Available', 'Booked'],
                datasets: [{
                    data: [{{ $availableRooms }}, {{ $bookedRooms }}],
                    backgroundColor: [
                        '#3B82F6',
                        '#EF4444',
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                cutout: '65%',
            }
        });
        
        const cards = document.querySelectorAll('.grid > div, .grid > a');
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
@endif
@endsection
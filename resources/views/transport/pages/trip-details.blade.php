@extends('transport.layouts.transport')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <a href="{{ route('transport.trips') }}" class="text-transport-blue hover:underline flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Trips
        </a>
        
        @if($isAssigned)
            <form action="{{ route('transport.withdraw-trip', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to withdraw from this trip?');">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors flex items-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Withdraw from Trip
                </button>
            </form>
        @else
            <form action="{{ route('transport.join-trip') }}" method="POST">
                @csrf
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                <button type="submit" class="bg-transport-green text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i> Join this Trip
                </button>
            </form>
        @endif
    </div>
</div>

<div class="bg-gradient-to-r from-transport-blue to-blue-600 text-white p-6 rounded-xl shadow-lg mb-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $trip->destination }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-white/90">
                <p><i class="far fa-calendar-alt mr-2"></i> {{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                <p><i class="far fa-clock mr-2"></i> {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                <p><i class="fas fa-users mr-2"></i> {{ $trip->travellers->count() }} travellers</p>
            </div>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="bg-white/20 p-4 rounded-full">
                <i class="fas fa-route text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-transport-blue text-white px-6 py-4">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-map-marked-alt mr-2"></i> Trip Itinerary
                </h2>
            </div>
            <div class="p-6">
                @if($trip->itinerary)
                    <h3 class="text-xl font-bold mb-2">{{ $trip->itinerary->title }}</h3>
                    <p class="text-gray-700">{{ $trip->itinerary->description }}</p>
                @else
                    <p class="text-gray-500 italic">No itinerary details available yet.</p>
                @endif
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-transport-green text-white px-6 py-4">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-hiking mr-2"></i> Activities
                </h2>
            </div>
            <div class="p-6">
                @if($trip->activities->count() > 0)
                    <div class="space-y-4">
                        @foreach($trip->activities->sortBy('scheduled_at') as $activity)
                            <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                <div class="flex flex-col md:flex-row md:items-start justify-between">
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800">{{ $activity->name }}</h3>
                                        <p class="text-gray-600"><i class="fas fa-map-marker-alt mr-2 text-transport-orange"></i>{{ $activity->location }}</p>
                                        <p class="text-gray-500 text-sm"><i class="far fa-clock mr-2"></i>{{ date('M d, Y - g:i A', strtotime($activity->scheduled_at)) }}</p>
                                        
                                        @if($activity->description)
                                            <p class="text-gray-700 mt-2 text-sm">{{ $activity->description }}</p>
                                        @endif
                                    </div>
                                    <div class="mt-2 md:mt-0">
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                            {{ \Carbon\Carbon::parse($activity->scheduled_at)->format('D') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">No activities have been added to this trip yet.</p>
                @endif
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-transport-orange text-white px-6 py-4">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-truck mr-2"></i> Transport Requirements
                </h2>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="font-bold text-gray-700 mb-2">Trip Distance</h3>
                    <p class="text-gray-800">Approximately 250 km</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="font-bold text-gray-700 mb-2">Vehicle Type Needed</h3>
                    <p class="text-gray-800">{{ $trip->travellers->count() > 10 ? 'Bus (20+ seats)' : ($trip->travellers->count() > 4 ? 'Mini-van (7-15 seats)' : 'Car (4-5 seats)') }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="font-bold text-gray-700 mb-2">Special Requirements</h3>
                    <ul class="list-disc list-inside text-gray-800">
                        <li>Air Conditioning</li>
                        <li>Comfortable seating for long journeys</li>
                        <li>Luggage space for {{ $trip->travellers->count() }} travellers</li>
                    </ul>
                </div>
                
                @if($isAssigned)
                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-2 rounded-full mr-3">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">You are assigned to this trip</h4>
                                <p class="text-gray-600 text-sm">Make sure your vehicle meets all requirements above</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-transport-blue text-white px-6 py-4">
                <h2 class="font-bold flex items-center">
                    <i class="fas fa-chart-pie mr-2"></i> Trip Overview
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-transport-blue/10 flex items-center justify-center mr-4">
                            <i class="fas fa-map-marker-alt text-transport-blue"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Destination</div>
                            <div class="font-medium">{{ $trip->destination }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-transport-green/10 flex items-center justify-center mr-4">
                            <i class="fas fa-calendar-alt text-transport-green"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Duration</div>
                            <div class="font-medium">{{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-transport-orange/10 flex items-center justify-center mr-4">
                            <i class="fas fa-users text-transport-orange"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Group Size</div>
                            <div class="font-medium">{{ $trip->travellers->count() }} travellers</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                            <i class="fas fa-hiking text-purple-500"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Activities</div>
                            <div class="font-medium">{{ $trip->activities->count() }} planned</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-transport-green text-white px-6 py-4">
                <h2 class="font-bold flex items-center">
                    <i class="fas fa-user-tie mr-2"></i> Tour Guides
                </h2>
            </div>
            <div class="p-6">
                @if($trip->guides->count() > 0)
                    <div class="space-y-4">
                        @foreach($trip->guides as $guide)
                            <div class="flex items-center">
                                <img src="{{ $guide->user->picture ? asset('storage/' . $guide->user->picture) : asset('images/default-profile.png') }}" 
                                     alt="Guide" class="w-10 h-10 rounded-full mr-4 object-cover">
                                <div>
                                    <div class="font-medium">{{ $guide->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $guide->specialization ?? 'Tour Guide' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">No guides assigned to this trip yet.</p>
                @endif
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-transport-orange text-white px-6 py-4">
                <h2 class="font-bold flex items-center">
                    <i class="fas fa-calendar-check mr-2"></i> Key Dates
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <div class="text-sm font-medium text-gray-500">Start Date</div>
                        <div class="text-sm font-bold bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                            {{ date('M d, Y', strtotime($trip->start_date)) }}
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="text-sm font-medium text-gray-500">End Date</div>
                        <div class="text-sm font-bold bg-red-100 text-red-800 px-3 py-1 rounded-full">
                            {{ date('M d, Y', strtotime($trip->end_date)) }}
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="text-sm font-medium text-gray-500">Departure Time</div>
                        <div class="text-sm font-bold">8:00 AM</div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-sm"></i>
                            </div>
                            <p class="text-sm text-gray-600">Please arrive 30 minutes before departure time</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

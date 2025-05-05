@extends('guide.layouts.guide')

@section('content')
<div class="flex items-center justify-between mb-6">
    <a href="{{ route('guide.trips') }}" class="flex items-center text-gray-600 hover:text-guide-blue">
        <i class="fas fa-arrow-left mr-2"></i> Back to Trips
    </a>
    
    @if(!$isAssigned)
        <form action="{{ route('guide.join-trip') }}" method="POST">
            @csrf
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
            <button type="submit" class="bg-guide-green hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                <i class="fas fa-check mr-2"></i> Join This Trip
            </button>
        </form>
    @else
        <form action="{{ route('guide.withdraw-trip', $trip->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300" onclick="return confirm('Are you sure you want to withdraw from this trip?')">
                <i class="fas fa-sign-out-alt mr-2"></i> Withdraw From Trip
            </button>
        </form>
    @endif
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="relative h-48 bg-gray-200">
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
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
            <h1 class="text-3xl font-bold">{{ $trip->destination }}</h1>
            <div class="flex items-center mt-2 text-sm">
                <i class="fas fa-calendar mr-2"></i>
                <span>{{ date('M d, Y', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</span>
                <span class="mx-2">|</span>
                <i class="fas fa-users mr-2"></i>
                <span>{{ $trip->travellers->count() }} travellers</span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Trip Overview</h2>
                
                @if($trip->itinerary)
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="font-bold text-lg mb-2">{{ $trip->itinerary->title }}</h3>
                        <p class="text-gray-600">{{ $trip->itinerary->description }}</p>
                    </div>
                @endif
                
                <h3 class="font-bold text-lg mb-3">Activities</h3>
                @if(count($trip->activities) > 0)
                    <div class="space-y-4 mb-6">
                        @foreach($trip->activities->sortBy('scheduled_at') as $activity)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-bold">{{ $activity->name }}</h4>
                                        <p class="text-gray-600 text-sm">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                            {{ $activity->location }}
                                        </p>
                                        <p class="text-gray-500 text-sm mt-1">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ date('M d, Y - g:i A', strtotime($activity->scheduled_at)) }}
                                        </p>
                                    </div>
                                </div>
                                @if($activity->description)
                                    <p class="text-gray-600 mt-2 text-sm">{{ $activity->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic mb-6">No activities have been planned for this trip yet.</p>
                @endif
                
                <h3 class="font-bold text-lg mb-3">Guide Requirements</h3>
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <p class="text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        This trip needs a guide for {{ $trip->travellers->count() }} travellers from 
                        {{ date('M d, Y', strtotime($trip->start_date)) }} to {{ date('M d, Y', strtotime($trip->end_date)) }}.
                    </p>
                    
                    @if($isAssigned)
                        <div class="mt-3 bg-green-100 p-3 rounded-lg">
                            <p class="text-green-700 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                You are assigned as a guide for this trip.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div>
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="font-bold text-lg mb-3">Trip Details</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-guide-blue mt-1 mr-3 w-5 text-center"></i>
                            <div>
                                <span class="text-gray-600">Destination:</span>
                                <p class="font-medium">{{ $trip->destination }}</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-calendar-alt text-guide-blue mt-1 mr-3 w-5 text-center"></i>
                            <div>
                                <span class="text-gray-600">Date Range:</span>
                                <p class="font-medium">{{ date('M d, Y', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock text-guide-blue mt-1 mr-3 w-5 text-center"></i>
                            <div>
                                <span class="text-gray-600">Duration:</span>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-users text-guide-blue mt-1 mr-3 w-5 text-center"></i>
                            <div>
                                <span class="text-gray-600">Travellers:</span>
                                <p class="font-medium">{{ $trip->travellers->count() }} people</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-bold text-lg mb-3">Team</h3>
                    
                    @if(count($trip->guides) > 0)
                        <div class="mb-4">
                            <h4 class="text-gray-600 text-sm font-medium mb-2">Guides:</h4>
                            <ul class="space-y-2">
                                @foreach($trip->guides as $guide)
                                    <li class="flex items-center">
                                        <div class="bg-blue-100 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <span>{{ $guide->user->name ?? 'Guide' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(count($trip->transports) > 0)
                        <div class="mb-4">
                            <h4 class="text-gray-600 text-sm font-medium mb-2">Transportation:</h4>
                            <ul class="space-y-2">
                                @foreach($trip->transports as $transport)
                                    <li class="flex items-center">
                                        <div class="bg-green-100 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-car text-green-600"></i>
                                        </div>
                                        <span>{{ $transport->company_name ?? 'Transport' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(count($trip->hotels) > 0)
                        <div>
                            <h4 class="text-gray-600 text-sm font-medium mb-2">Accommodations:</h4>
                            <ul class="space-y-2">
                                @foreach($trip->hotels as $hotel)
                                    <li class="flex items-center">
                                        <div class="bg-red-100 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-hotel text-red-600"></i>
                                        </div>
                                        <span>{{ $hotel->name ?? 'Hotel' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

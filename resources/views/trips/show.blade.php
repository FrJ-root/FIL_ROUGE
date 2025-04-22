@extends('layouts.app')

@section('content')
    @include('components.sidebar')
    <div 
        x-data="{ sidebarCollapsed: true }"
        @sidebar-state-changed.window="sidebarCollapsed = $event.detail.isCollapsed"
        :class="{'md:ml-64': !sidebarCollapsed, 'md:ml-16': sidebarCollapsed}"
        class="transition-all duration-300" 
        id="main-content"
    >
        @php
            $coverImageUrl = null;
            if ($trip->cover_picture) {
                $coverImageUrl = asset('storage/images/trip/' . $trip->cover_picture);
            } else {
                // Fallback to destination image if cover_picture is not set
                $destinationName = explode(',', $trip->destination)[0] ?? '';
                $destination = App\Models\Destination::where('name', $destinationName)->first();
                $coverImageUrl = $destination ? getDestinationImageUrl($destination->name, $destination->location) 
                         : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
            }
        @endphp
        
        <!-- Enhanced Hero Section with Parallax Effect -->
        <div class="relative w-full h-[500px] md:h-[600px] overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center transform transition-transform duration-700 hover:scale-105" 
                 style="background-image: url('{{ $coverImageUrl }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/50 to-black/80"></div>
            
            <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-16">
                <div class="container mx-auto">
                    <div class="flex flex-col md:flex-row md:items-end justify-between">
                        <div class="text-white mb-8 md:mb-0 max-w-2xl" data-aos="fade-up" data-aos-delay="100">
                            <div class="mb-4">
                                <a href="{{ route('trips.index') }}" class="text-white/80 hover:text-white transition-colors inline-flex items-center group">
                                    <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> 
                                    <span class="border-b border-transparent group-hover:border-white">Back to Trips</span>
                                </a>
                            </div>
                            <h1 class="text-5xl md:text-6xl font-bold mb-4 drop-shadow-lg">{{ $trip->destination }}</h1>
                            <div class="flex flex-wrap items-center gap-6 text-white/90 text-lg">
                                <p class="flex items-center"><i class="far fa-calendar-alt mr-2 text-yellow-400"></i> {{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                                <p class="flex items-center"><i class="far fa-clock mr-2 text-green-400"></i> {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                                <p class="flex items-center"><i class="fas fa-users mr-2 text-blue-400"></i> {{ $trip->travellers->count() }} travellers</p>
                            </div>
                        </div>
                        
                        @if(isset($canEdit) && $canEdit)
                        <div class="flex gap-3" data-aos="fade-up" data-aos-delay="200">
                            <a href="{{ route('trips.edit', $trip->id) }}" class="bg-yellow-500 text-white px-5 py-3 rounded-lg hover:bg-yellow-600 transition-colors transform hover:scale-105 hover:shadow-lg flex items-center">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-5 py-3 rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105 hover:shadow-lg flex items-center">
                                    <i class="fas fa-trash-alt mr-2"></i> Delete
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="container mx-auto px-4 py-12">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Trip Details -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Trip Overview Card -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100" data-aos="fade-up">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5">
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <i class="fas fa-compass mr-3"></i> Trip Overview
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="prose max-w-none">
                                <p class="text-gray-700 leading-relaxed">
                                    Experience the beauty and culture of {{ $trip->destination }} on this {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }}-day adventure. 
                                    This journey takes you through the heart of this amazing destination, offering unforgettable experiences and memories.
                                </p>
                                
                                @if($trip->itinerary && $trip->itinerary->description)
                                <div class="mt-6">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Itinerary Details</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        {{ $trip->itinerary->description }}
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Trip Booking Section -->
                                <div class="mt-8">
                                    @auth
                                        @if(auth()->user()->role === 'traveller')
                                            @php
                                                $hasTripAlready = false;
                                                if(auth()->user()->traveller) {
                                                    $hasTripAlready = auth()->user()->traveller->trip_id == $trip->id;
                                                }
                                            @endphp
                                            
                                            @if($hasTripAlready)
                                                <div class="bg-green-50 text-green-700 px-6 py-4 rounded-xl border border-green-200 flex items-center">
                                                    <i class="fas fa-check-circle text-2xl mr-3"></i>
                                                    <div>
                                                        <h4 class="font-bold">You're booked for this trip!</h4>
                                                        <p class="text-sm">Check your traveller dashboard for more details</p>
                                                    </div>
                                                </div>
                                            @else
                                                <form action="{{ route('traveller.trips.add', $trip->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-4 border border-transparent rounded-xl shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-1 hover:shadow-lg">
                                                        <i class="fas fa-suitcase-rolling mr-2"></i>
                                                        Book this trip
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    @endauth
                                    
                                    @guest
                                        <a href="{{ route('login') }}" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-4 border border-transparent rounded-xl shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-1 hover:shadow-lg">
                                            <i class="fas fa-sign-in-alt mr-2"></i>
                                            Login to book this trip
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activities Section -->
                    @if($trip->activities && $trip->activities->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                        <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-5">
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <i class="fas fa-hiking mr-3"></i> Planned Activities
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                @foreach($trip->activities as $activity)
                                <div class="flex items-start border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                    <div class="bg-green-100 text-green-600 p-3 rounded-full mr-4">
                                        <i class="fas fa-map-pin"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-lg">{{ $activity->name }}</h3>
                                        <div class="flex items-center text-sm text-gray-500 mb-2">
                                            <i class="fas fa-map-marker-alt mr-2"></i> {{ $activity->location }}
                                            <span class="mx-2">•</span>
                                            <i class="far fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::parse($activity->scheduled_at)->format('M d, Y - h:i A') }}
                                        </div>
                                        <p class="text-gray-600">{{ $activity->description }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Trip Details Card -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100" data-aos="fade-up" data-aos-delay="150">
                        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-5">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <i class="fas fa-info-circle mr-3"></i> Trip Details
                            </h2>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-4">
                                <li class="flex items-center text-gray-700">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Destination</span>
                                        <p class="font-medium">{{ $trip->destination }}</p>
                                    </div>
                                </li>
                                
                                <li class="flex items-center text-gray-700">
                                    <div class="bg-green-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-calendar-alt text-green-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Trip Dates</span>
                                        <p class="font-medium">{{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                                    </div>
                                </li>
                                
                                <li class="flex items-center text-gray-700">
                                    <div class="bg-yellow-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-clock text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Duration</span>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                                    </div>
                                </li>
                                
                                <li class="flex items-center text-gray-700">
                                    <div class="bg-purple-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-users text-purple-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Group Size</span>
                                        <p class="font-medium">{{ $trip->travellers->count() }} travellers</p>
                                    </div>
                                </li>
                                
                                @if($trip->manager)
                                <li class="flex items-center text-gray-700">
                                    <div class="bg-red-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-user-tie text-red-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Trip Manager</span>
                                        <p class="font-medium">{{ $trip->manager->name }}</p>
                                    </div>
                                </li>
                                @endif
                                
                                <!-- NEW: View on Map Link -->
                                <li class="flex items-center text-gray-700 pt-4 border-t border-gray-100">
                                    <a href="{{ route('maps.index') }}?search={{ urlencode($trip->destination) }}" 
                                       class="flex items-center w-full text-indigo-600 hover:text-indigo-800 transition-colors group">
                                        <div class="bg-indigo-100 p-2 rounded-full mr-3 group-hover:bg-indigo-200 transition-colors">
                                            <i class="fas fa-map text-indigo-600"></i>
                                        </div>
                                        <span class="font-medium">View on Interactive Map</span>
                                        <i class="fas fa-arrow-right ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </a>
                                </li>
                                
                                <!-- NEW: View Destination Link -->
                                @php
                                    $destinationName = explode(',', $trip->destination)[0] ?? '';
                                    $destination = \App\Models\Destination::where('name', 'like', $destinationName . '%')->first();
                                @endphp
                                
                                @if($destination)
                                <li class="flex items-center text-gray-700 pt-2">
                                    <a href="{{ route('destinations.show', $destination->slug) }}" 
                                       class="flex items-center w-full text-teal-600 hover:text-teal-800 transition-colors group">
                                        <div class="bg-teal-100 p-2 rounded-full mr-3 group-hover:bg-teal-200 transition-colors">
                                            <i class="fas fa-globe-americas text-teal-600"></i>
                                        </div>
                                        <span class="font-medium">Explore {{ $destination->name }}</span>
                                        <i class="fas fa-arrow-right ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Team Card -->
                    @if(($trip->guides && $trip->guides->count() > 0) || ($trip->hotels && $trip->hotels->count() > 0) || ($trip->transports && $trip->transports->count() > 0))
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-5">
                            <h2 class="text-xl font-bold text-white flex items-center">
                                <i class="fas fa-user-friends mr-3"></i> Trip Team
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                @if($trip->guides && $trip->guides->count() > 0)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-map text-teal-600 mr-2"></i> Guides
                                    </h3>
                                    <ul class="space-y-3">
                                        @foreach($trip->guides as $guide)
                                        <li class="flex items-center bg-gray-50 p-3 rounded-lg">
                                            <div class="bg-teal-500 text-white w-10 h-10 rounded-full flex items-center justify-center mr-3">
                                                {{ strtoupper(substr($guide->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $guide->user->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $guide->specialization ?? 'Tour Guide' }}</p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                
                                @if($trip->hotels && $trip->hotels->count() > 0)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-hotel text-indigo-600 mr-2"></i> Accommodation
                                    </h3>
                                    <ul class="space-y-3">
                                        @foreach($trip->hotels as $hotel)
                                        <li class="flex items-center bg-gray-50 p-3 rounded-lg">
                                            <div class="bg-indigo-500 text-white w-10 h-10 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-hotel"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $hotel->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $hotel->city }}, {{ $hotel->country }}</p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                
                                @if($trip->transports && $trip->transports->count() > 0)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-shuttle-van text-blue-600 mr-2"></i> Transport
                                    </h3>
                                    <ul class="space-y-3">
                                        @foreach($trip->transports as $transport)
                                        <li class="flex items-center bg-gray-50 p-3 rounded-lg">
                                            <div class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-{{ $transport->transport_type == 'Bus' ? 'bus' : ($transport->transport_type == 'Plane' ? 'plane' : 'car') }}"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $transport->company_name }}</p>
                                                <p class="text-sm text-gray-500">{{ $transport->transport_type }}</p>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Trips Section -->
        <div class="bg-gradient-to-b from-gray-50 to-gray-100 py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-gray-800 mb-2 flex items-center" data-aos="fade-up">
                    <i class="fas fa-map-signs text-indigo-600 mr-3"></i> Similar Adventures
                </h2>
                <p class="text-gray-600 mb-10 max-w-3xl" data-aos="fade-up" data-aos-delay="50">
                    Discover more amazing trips like this one. These destinations might interest you based on your current adventure.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($relatedTrips as $relatedTrip)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="h-48 overflow-hidden relative">
                            @php
                                $relatedImageUrl = null;
                                if ($relatedTrip->cover_picture) {
                                    $relatedImageUrl = asset('storage/images/trip/' . $relatedTrip->cover_picture);
                                } else {
                                    $relatedDestName = explode(',', $relatedTrip->destination)[0] ?? '';
                                    $relatedDest = App\Models\Destination::where('name', $relatedDestName)->first();
                                    $relatedImageUrl = $relatedDest ? getDestinationImageUrl($relatedDest->name, $relatedDest->location) 
                                       : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
                                }
                            @endphp
                            <img src="{{ $relatedImageUrl }}" alt="{{ $relatedTrip->destination }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70 flex items-end p-4">
                                <div class="w-full">
                                    <span class="px-3 py-1 bg-indigo-600/80 text-white text-xs rounded-full backdrop-blur-sm inline-block mb-2">
                                        {{ \Carbon\Carbon::parse($relatedTrip->start_date)->diffInDays($relatedTrip->end_date) + 1 }} days
                                    </span>
                                    <h3 class="text-xl font-bold text-white group-hover:text-indigo-200 transition-colors">{{ $relatedTrip->destination }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <i class="far fa-calendar-alt mr-1 text-indigo-500"></i>
                                    {{ date('M d', strtotime($relatedTrip->start_date)) }} - {{ date('M d', strtotime($relatedTrip->end_date)) }}
                                </div>
                                <div class="flex items-center">
                                    <div class="flex -space-x-2">
                                        @for ($i = 0; $i < min(3, $relatedTrip->travellers->count()); $i++)
                                            <div class="w-7 h-7 rounded-full bg-indigo-100 border-2 border-white flex items-center justify-center text-xs text-indigo-600 font-bold">
                                                {{ strtoupper(substr($relatedTrip->travellers[$i]->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                        @endfor
                                        @if($relatedTrip->travellers->count() > 3)
                                            <div class="w-7 h-7 rounded-full bg-indigo-500 border-2 border-white flex items-center justify-center text-xs text-white font-bold">
                                                +{{ $relatedTrip->travellers->count() - 3 }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex items-center space-x-1">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star text-{{ $i < 4 ? 'yellow' : 'gray' }}-400 text-sm"></i>
                                    @endfor
                                    <span class="text-xs text-gray-500 ml-1">({{ rand(3, 25) }})</span>
                                </div>
                                <a href="{{ route('trips.show', $relatedTrip->id) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors group-hover:translate-x-1 duration-300">
                                    View Details
                                    <i class="fas fa-arrow-right ml-1 transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="lg:col-span-3 text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-500">
                            <i class="fas fa-search text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-700 mb-2">No Similar Adventures Found</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">We couldn't find any similar trips at this time. Try browsing our other popular destinations instead.</p>
                        <a href="{{ route('trips.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Browse All Trips <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    @endforelse
                </div>
                
                <!-- More Trips Button -->
                @if(count($relatedTrips) > 0)
                <div class="mt-12 text-center" data-aos="fade-up">
                    <a href="{{ route('trips.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition duration-300 shadow-sm hover:shadow">
                        Explore More Adventures <i class="fas fa-compass ml-2"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Enhanced parallax effect */
    .bg-cover {
        background-size: cover;
        transition: transform 0.7s ease-out;
    }
    
    .bg-cover:hover {
        transform: scale(1.05);
    }
    
    /* Smooth animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Card hover effects */
    .hover-card {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    /* Typography enhancements */
    h1, h2, h3 {
        letter-spacing: -0.02em;
    }
    
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        background-image: linear-gradient(to right, #3b82f6, #8b5cf6);
    }
    
    /* Enhanced cards for Similar Adventures section */
    .similar-adventure-card {
        backface-visibility: hidden;
        transform: perspective(1000px) translateZ(0);
    }

    .similar-adventure-card:hover .card-overlay {
        opacity: 1;
    }

    .similar-adventure-card:hover .card-details {
        transform: translateY(0);
    }

    .card-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .card-details {
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }

    @keyframes pulse-soft {
        0% {
            box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(79, 70, 229, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
        }
    }

    .pulse-soft {
        animation: pulse-soft 2s infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate elements on scroll using Intersection Observer API
        const animatedElements = document.querySelectorAll('.bg-white.rounded-2xl, .grid > div');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        animatedElements.forEach(element => {
            element.style.opacity = '0';
            observer.observe(element);
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add hover effects to similar adventures cards
        const similarAdventureCards = document.querySelectorAll('.grid > div');
        similarAdventureCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('img')?.classList.add('scale-110');
            });
            
            card.addEventListener('mouseleave', function() {
                this.querySelector('img')?.classList.remove('scale-110');
            });
        });
    });
    
    // Helper functions
    function safeToggle(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.classList.toggle('hidden');
            return true;
        }
        return false;
    }
    
    function toggleItineraryForm() {
        if (safeToggle('itinerary-form')) {
            safeToggle('itinerary-display');
        }
    }
    
    function toggleActivityForm() {
        safeToggle('activity-form');
    }
    
    function toggleTravellerForm() {
        safeToggle('traveller-form');
    }
</script>
@endpush
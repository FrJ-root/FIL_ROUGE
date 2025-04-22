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
        <div class="relative w-full h-96 md:h-[500px] overflow-hidden mb-8">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $coverImageUrl }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/50 to-black/70"></div>
            <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-12">
                <div class="container mx-auto">
                    <div class="flex flex-col md:flex-row md:items-end justify-between">
                        <div class="text-white mb-6 md:mb-0">
                            <div class="mb-2">
                                <a href="{{ route('trips.index') }}" class="text-white/80 hover:text-white transition-colors inline-flex items-center">
                                    <i class="fas fa-arrow-left mr-2"></i> Back to Trips
                                </a>
                            </div>
                            <h1 class="text-4xl md:text-5xl font-bold mb-2 drop-shadow-lg">{{ $trip->destination }}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-white/90">
                                <p><i class="far fa-calendar-alt mr-2"></i> {{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                                <p><i class="far fa-clock mr-2"></i> {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                                <p><i class="fas fa-users mr-2"></i> {{ $trip->travellers->count() }} travellers</p>
                            </div>
                        </div>
                        @if(isset($canEdit) && $canEdit)
                        <div class="flex gap-2">
                            <a href="{{ route('trips.edit', $trip->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8 mt-16">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Trip Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                            <h1 class="text-2xl font-bold text-white">{{ $trip->destination }}</h1>
                            <div class="flex items-center text-blue-100 mt-2">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ date('M d, Y', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <!-- Trip details information -->
                            
                            <!-- Add "Trip with us" button for authenticated travellers -->
                            @auth
                                @if(auth()->user()->role === 'traveller')
                                    @php
                                        $hasTripAlready = false;
                                        if(auth()->user()->traveller) {
                                            $hasTripAlready = auth()->user()->traveller->trip_id == $trip->id;
                                        }
                                    @endphp
                                    
                                    @if($hasTripAlready)
                                        <div class="mt-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                                            <div class="flex items-center">
                                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>You're already booked for this trip!</span>
                                            </div>
                                        </div>
                                    @else
                                        <form action="{{ route('traveller.trips.add', $trip->id) }}" method="POST" class="mt-4">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Trip with us
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                            
                            @guest
                                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 mt-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Login to book this trip
                                </a>
                            @endguest
                        </div>
                    </div>
                    
                    <!-- Rest of trip details content -->
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Sidebar content -->
                </div>
            </div>
        </div>

        <!-- Related Trips Section -->
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Trips</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedTrips as $trip)
                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="h-36 bg-gray-200 relative">
                        @php
                            $imageUrl = null;
                            if ($trip->cover_picture) {
                                $imageUrl = asset('storage/trips/' . $trip->cover_picture);
                            } else {
                                // Fallback to destination image if cover_picture is not set
                                $destinationName = explode(',', $trip->destination)[0] ?? '';
                                $destination = App\Models\Destination::where('name', $destinationName)->first();
                                $imageUrl = $destination ? getDestinationImageUrl($destination->name, $destination->location) 
                                       : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $trip->destination }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800">{{ $trip->destination }}</h3>
                        <p class="text-sm text-gray-600">{{ date('M d, Y', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                        <a href="{{ route('trips.show', $trip->id) }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">View Trip</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Parallax-like effect for the hero image */
    .bg-cover {
        background-size: cover;
        transition: transform 0.5s ease;
    }
    /* Subtle zoom effect on hover */
    .relative:hover .bg-cover {
        transform: scale(1.05);
    }
    /* Add some motion to the page when content scrolls */
    .relative {
        perspective: 1000px;
    }
    /* Enhance shadow effect on cards */
    .shadow-md:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
@endpush

@push('scripts')
<script>
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
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
        <div class="container mx-auto px-4 py-8 mt-16">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Discover Trips</h1>
                @auth
                    @if(isset($canCreateTrips) && $canCreateTrips)
                    <a href="{{ route('trips.create') }}" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i> Create New Trip
                    </a>
                    @elseif(auth()->user()->role === 'hotel' || auth()->user()->role === 'guide' || auth()->user()->role === 'transport')
                    <a href="{{ route(auth()->user()->role . '.available-trips') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                        <i class="fas fa-handshake mr-2"></i> Find Trips to Collaborate
                    </a>
                    @endif
                @else
                    <a href="{{ route('login') }}?redirect={{ route('trips.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login to Join Trips
                    </a>
                @endauth
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- All Trips Section -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Browse All Trips</h2>
                
                @if(isset($trips) && count($trips) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($trips as $trip)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow trip-card">
                        <div class="trip-card-image">
                            @php
                                $imageUrl = null;
                                if ($trip->cover_picture) {
                                    $imageUrl = asset('storage/images/trip/' . $trip->cover_picture);
                                } else {
                                    $destinationName = explode(',', $trip->destination)[0] ?? '';
                                    $destination = App\Models\Destination::where('name', $destinationName)->first();
                                    $imageUrl = $destination ? getDestinationImageUrl($destination->name, $destination->location) 
                                        : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" class="w-full h-full object-cover" alt="{{ $trip->destination }}">
                            <div class="trip-dates">
                                {{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $trip->destination }}</h3>
                            <div class="mb-3">
                                <p class="text-gray-600"><i class="far fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                                <p class="text-gray-700 mt-2">
                                    <span class="font-medium">Activities:</span> {{ $trip->activities->count() }}
                                </p>
                                <p class="text-gray-700">
                                    <span class="font-medium">Travellers:</span> {{ $trip->travellers->count() }}
                                </p>
                            </div>
                            
                            @if($trip->tags && $trip->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($trip->tags->take(3) as $tag)
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">{{ $tag->name }}</span>
                                @endforeach
                                @if($trip->tags->count() > 3)
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">+{{ $trip->tags->count() - 3 }}</span>
                                @endif
                            </div>
                            @endif
                            
                            <div class="flex justify-center mt-4">
                                <a href="{{ route('trips.show', $trip->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-8 flex justify-center">
                    {{ $trips->links() }}
                </div>
                @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-600">No trips found. Be the first to create a trip!</p>
                </div>
                @endif
            </section>

            @auth
            <section>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">My Trips</h2>
                
                @if(isset($userTrips) && count($userTrips) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($userTrips as $trip)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow trip-card">
                        <div class="trip-card-image">
                            @php
                                $imageUrl = null;
                                if ($trip->cover_picture) {
                                    $imageUrl = asset('storage/images/trips/' . $trip->cover_picture);
                                } else {
                                    $destinationName = explode(',', $trip->destination)[0] ?? '';
                                    $destination = App\Models\Destination::where('name', $destinationName)->first();
                                    $imageUrl = $destination ? getDestinationImageUrl($destination->name, $destination->location) 
                                        : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" class="w-full h-full object-cover" alt="{{ $trip->destination }}">
                            <div class="trip-dates">
                                {{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $trip->destination }}</h3>
                            <div class="mb-3">
                                <p class="text-gray-600"><i class="far fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                                <p class="text-gray-700 mt-2">
                                    <span class="font-medium">Activities:</span> {{ $trip->activities->count() }}
                                </p>
                                <p class="text-gray-700">
                                    <span class="font-medium">Travellers:</span> {{ $trip->travellers->count() }}
                                </p>
                            </div>
                            
                            <div class="flex justify-between mt-4">
                                <a href="{{ route('trips.show', $trip->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <a href="{{ route('trips.edit', $trip->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition-colors">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-8 flex justify-center">
                    {{ $userTrips->links() }}
                </div>
                @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <i class="fas fa-suitcase-rolling text-red-500 text-5xl mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">No trips found</h2>
                    <p class="text-gray-600 mb-6">You haven't created any trips yet. Start planning your next adventure!</p>
                    <a href="{{ route('trips.create') }}" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-colors inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i> Create Your First Trip
                    </a>
                </div>
                @endif
            </section>
            @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center mt-8">
                <i class="fas fa-plane-departure text-red-500 text-5xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Ready to plan your perfect trip?</h2>
                <p class="text-gray-600 mb-6">Sign in to create and manage your custom trips!</p>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-colors inline-flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> Register
                    </a>
                </div>
            </div>
            @endauth
        </div>
    </div>

    @push('styles')
    <style>
        .trip-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .trip-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .trip-card-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        
        .trip-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .trip-card:hover .trip-card-image img {
            transform: scale(1.05);
        }
        
        .trip-dates {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
            color: white;
            padding: 15px;
            font-weight: bold;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
            font-weight: 500;
        }
        
        .pagination li {
            margin: 0 3px;
        }
        
        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border-radius: 8px;
            background: white;
            color: #374151;
            border: 1px solid #e5e7eb;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .pagination li a:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }
        
        .pagination li.active span {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }
        
        .pagination li.disabled span {
            color: #9ca3af;
            pointer-events: none;
        }
        
        @media (max-width: 640px) {
            .pagination li a,
            .pagination li span {
                min-width: 32px;
                height: 32px;
                padding: 0 8px;
                font-size: 0.875rem;
            }
        }
    </style>
    @endpush
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebarWrapper = document.querySelector('.sidebar-wrapper');
        if (sidebarWrapper) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'x-data') {
                        const sidebarData = Alpine.raw(Alpine.$data(sidebarWrapper));
                        const mainContent = document.getElementById('main-content');
                        
                        if (sidebarData && mainContent) {
                            if (sidebarData.isCollapsed) {
                                mainContent.classList.remove('md:ml-64');
                                mainContent.classList.add('md:ml-16');
                            } else {
                                mainContent.classList.remove('md:ml-16');
                                mainContent.classList.add('md:ml-64');
                            }
                        }
                    }
                });
            });
            
            observer.observe(sidebarWrapper, { attributes: true });
        }
    });
</script>
@endpush

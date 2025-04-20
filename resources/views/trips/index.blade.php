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
            <!-- Hero Banner -->
            <div class="relative rounded-2xl overflow-hidden mb-10 shadow-xl">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 opacity-90"></div>
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1488085061387-422e29b40080?ixlib=rb-4.0.3')] bg-cover bg-center mix-blend-overlay"></div>
                <div class="relative z-10 py-12 px-8 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold mb-3">Discover Amazing Trips</h1>
                    <p class="text-xl max-w-xl text-white/90 mb-6">Explore the world with our carefully crafted trips designed to create lasting memories</p>
                    <div class="flex flex-wrap gap-4">
                        @auth
                            @if(isset($canCreateTrips) && $canCreateTrips)
                            <a href="{{ route('trips.create') }}" class="bg-white text-purple-700 hover:bg-gray-100 px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 flex items-center shadow-md hover:shadow-lg">
                                <i class="fas fa-plus mr-2"></i> Create New Trip
                            </a>
                            @elseif(auth()->user()->role === 'hotel' || auth()->user()->role === 'guide' || auth()->user()->role === 'transport')
                            <a href="{{ route(auth()->user()->role . '.available-trips') }}" class="bg-white text-blue-700 hover:bg-gray-100 px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 flex items-center shadow-md hover:shadow-lg">
                                <i class="fas fa-handshake mr-2"></i> Find Trips to Collaborate
                            </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}?redirect={{ route('trips.index') }}" class="bg-white text-blue-700 hover:bg-gray-100 px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 flex items-center shadow-md hover:shadow-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login to Join Trips
                            </a>
                        @endauth
                        <a href="#trips" class="bg-transparent hover:bg-white/20 border-2 border-white px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center">
                            <i class="fas fa-search mr-2"></i> Explore Trips
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 md:mb-0">Find Your Perfect Trip</h2>
                    <div class="flex flex-wrap gap-3">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Search destinations..." 
                                   class="bg-gray-100 px-10 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-700">
                        </div>
                        <select class="bg-gray-100 px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-700 appearance-none cursor-pointer pr-8 relative">
                            <option>Any Duration</option>
                            <option>Short (1-3 days)</option>
                            <option>Medium (4-7 days)</option>
                            <option>Long (8+ days)</option>
                        </select>
                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-full transition-colors">
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- All Trips Section -->
            <section id="trips" class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-globe-africa text-purple-600 mr-2"></i>Browse All Trips
                </h2>
                
                @if(isset($trips) && count($trips) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($trips as $trip)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <div class="relative h-60 overflow-hidden">
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
                            <img src="{{ $imageUrl }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $trip->destination }}">
                            <div class="absolute top-0 right-0 m-4">
                                @php
                                    $today = date('Y-m-d');
                                    $statusClass = '';
                                    $statusText = '';
                                    
                                    if ($trip->end_date < $today) {
                                        $statusText = 'Completed';
                                        $statusClass = 'bg-gray-600';
                                    } elseif ($trip->start_date <= $today) {
                                        $statusText = 'Active';
                                        $statusClass = 'bg-green-600';
                                    } else {
                                        $statusText = 'Upcoming';
                                        $statusClass = 'bg-blue-600';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} text-white px-2 py-1 rounded-full text-xs font-bold shadow-md">
                                    {{ $statusText }}
                                </span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent text-white">
                                <div class="font-bold text-lg">{{ $trip->destination }}</div>
                                <div class="flex items-center text-sm">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="flex items-center text-gray-700 mb-2">
                                        <i class="fas fa-clock text-purple-600 mr-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-users text-purple-600 mr-2"></i>
                                        <span>{{ $trip->travellers->count() }} travellers</span>
                                    </div>
                                </div>
                                <div class="bg-purple-100 text-purple-800 rounded-full px-3 py-1 text-xs font-semibold">
                                    {{ $trip->activities->count() }} activities
                                </div>
                            </div>
                            
                            @if($trip->tags && $trip->tags->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($trip->tags->take(3) as $tag)
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $tag->name }}</span>
                                @endforeach
                                @if($trip->tags->count() > 3)
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">+{{ $trip->tags->count() - 3 }}</span>
                                @endif
                            </div>
                            @endif
                            
                            <a href="{{ route('trips.show', $trip->id) }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white rounded-lg py-2 px-4 transition-colors group-hover:shadow-lg">
                                <i class="fas fa-info-circle mr-1"></i> View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-8 flex justify-center">
                    {{ $trips->links() }}
                </div>
                @else
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <img src="{{ asset('images/no-trips.svg') }}" alt="No trips found" class="w-64 h-64 mx-auto mb-6">
                    <p class="text-gray-600 mb-3">No trips found. Be the first to create a trip!</p>
                    <a href="{{ route('trips.create') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i> Create Trip
                    </a>
                </div>
                @endif
            </section>

            <!-- ...remaining code for My Trips section... -->
        </div>
    </div>

    @push('styles')
    <style>
        /* Card Styles */
        .trip-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            will-change: transform;
        }
        
        .trip-card:hover {
            transform: translateY(-10px);
        }
        
        /* Custom pagination styling */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 0.5rem;
        }
        
        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            padding: 0.5rem 1rem;
            background: white;
            border: 1px solid #e5e7eb;
            color: #4b5563;
            font-weight: 500;
            min-width: 2.5rem;
            transition: all 0.15s ease;
        }
        
        .pagination li.active span {
            background: #8b5cf6;
            color: white;
            border-color: #8b5cf6;
        }
        
        .pagination li a:hover:not(.active) {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Gradient text */
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #8b5cf6, #6d28d9);
        }
    </style>
    @endpush
@endsection

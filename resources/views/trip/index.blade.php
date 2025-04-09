@extends('layouts.app')

@section('content')
<div class="pt-24">
    <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-green-500 to-blue-600 text-white rounded-xl p-8 mb-10 shadow-lg relative overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('assets/images/travel-bg.jpg') }}');"></div>
            <div class="relative z-10">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Explore Our Travel Guides</h1>
                <p class="text-xl mb-6 max-w-2xl">Discover amazing destinations with insider tips, local recommendations, and complete travel itineraries.</p>
                
                <!-- Search Bar -->
                <form action="{{ route('travel-guides') }}" method="GET" class="max-w-2xl">
                    <div class="flex flex-wrap md:flex-nowrap gap-3">
                        <div class="flex-1">
                            <input type="text" name="search" placeholder="Search destinations or guides..." 
                                class="w-full px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-colors duration-300 font-bold">
                            <i class="fas fa-search mr-2"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Filters Section -->
        <div class="mb-8 bg-white p-5 rounded-lg shadow-md">
            <form action="{{ route('travel-guides') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Destination</label>
                    <select name="destination" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-500">
                        <option value="">All Destinations</option>
                        @foreach($destinations ?? [] as $destination)
                            <option value="{{ $destination->id }}" {{ request('destination') == $destination->id ? 'selected' : '' }}>
                                {{ $destination->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select name="category" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-500">
                        <option value="">All Categories</option>
                        <option value="1" {{ request('category') == 1 ? 'selected' : '' }}>Adventure</option>
                        <option value="2" {{ request('category') == 2 ? 'selected' : '' }}>Family Friendly</option>
                        <option value="3" {{ request('category') == 3 ? 'selected' : '' }}>Budget Travel</option>
                        <option value="4" {{ request('category') == 4 ? 'selected' : '' }}>Luxury</option>
                    </select>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-300">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Featured Guides Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-l-4 border-red-500 pl-3">Featured Travel Guides</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($featuredGuides ?? [] as $guide)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 relative">
                        <div class="absolute top-0 right-0 bg-red-500 text-white px-3 py-1 rounded-bl-lg font-bold">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                        <img src="{{ $guide->image ?? asset('assets/images/placeholder.jpg') }}" alt="{{ $guide->title }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-2 text-gray-800">{{ $guide->title ?? 'Discover Paris' }}</h2>
                            <p class="text-gray-600 mb-4">{{ Str::limit($guide->description ?? 'Explore the city of lights with our comprehensive guide to Paris\'s must-see attractions.', 100) }}</p>
                            <a href="{{ route('travel-guides.show', $guide->slug ?? 'paris') }}" class="text-red-500 font-bold hover:text-red-600">Read more →</a>
                        </div>
                    </div>
                @empty
                    <!-- Fallback content when there are no featured guides -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 relative">
                        <div class="absolute top-0 right-0 bg-red-500 text-white px-3 py-1 rounded-bl-lg font-bold">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Travel Guide" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-2 text-gray-800">Discover Paris</h2>
                            <p class="text-gray-600 mb-4">Explore the city of lights with our comprehensive guide to Paris's must-see attractions.</p>
                            <a href="{{ route('travel-guides.show', 'paris') }}" class="text-red-500 font-bold hover:text-red-600">Read more →</a>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 relative">
                        <div class="absolute top-0 right-0 bg-red-500 text-white px-3 py-1 rounded-bl-lg font-bold">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Travel Guide" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-2 text-gray-800">Tokyo Adventures</h2>
                            <p class="text-gray-600 mb-4">Navigate the bustling streets of Tokyo with insider tips and cultural insights.</p>
                            <a href="{{ route('travel-guides.show', 'tokyo') }}" class="text-red-500 font-bold hover:text-red-600">Read more →</a>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 relative">
                        <div class="absolute top-0 right-0 bg-red-500 text-white px-3 py-1 rounded-bl-lg font-bold">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Travel Guide" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-2 text-gray-800">New York City Guide</h2>
                            <p class="text-gray-600 mb-4">From iconic landmarks to hidden gems, discover the best of the Big Apple.</p>
                            <a href="{{ route('travel-guides.show', 'new-york') }}" class="text-red-500 font-bold hover:text-red-600">Read more →</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- All Travel Guides Section -->
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-l-4 border-green-500 pl-3">All Travel Guides</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($guides ?? [] as $guide)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ $guide->image ?? asset('assets/images/placeholder.jpg') }}" alt="{{ $guide->title }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $guide->category->name ?? 'Adventure' }}
                            </span>
                            <span class="ml-2 text-gray-500 text-sm">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $guide->destination->name ?? 'Paris, France' }}
                            </span>
                        </div>
                        <h2 class="text-xl font-bold mb-2 text-gray-800">{{ $guide->title ?? 'Amazing Destination' }}</h2>
                        <p class="text-gray-600 mb-4">{{ Str::limit($guide->description ?? 'Discover the wonders of this amazing destination with our comprehensive travel guide.', 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-eye mr-1"></i> {{ $guide->views ?? '1.2k' }} views
                            </span>
                            <a href="{{ route('travel-guides.show', $guide->slug ?? 'destination') }}" class="text-red-500 font-bold hover:text-red-600">Read more →</a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback cards when no guides are available -->
                @for ($i = 0; $i < 6; $i++)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Travel Guide" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <div class="flex items-center mb-2">
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    {{ ['Adventure', 'Family', 'Budget', 'Luxury'][rand(0,3)] }}
                                </span>
                                <span class="ml-2 text-gray-500 text-sm">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ ['Paris, France', 'London, UK', 'Rome, Italy', 'Barcelona, Spain', 'Tokyo, Japan', 'New York, USA'][rand(0,5)] }}
                                </span>
                            </div>
                            <h2 class="text-xl font-bold mb-2 text-gray-800">{{ ['Amazing Paris Guide', 'Tokyo Travel Tips', 'New York in 3 Days', 'London Explorer', 'Rome Travel Secrets', 'Barcelona Weekend Guide'][rand(0,5)] }}</h2>
                            <p class="text-gray-600 mb-4">Discover the wonders of this amazing destination with our comprehensive travel guide.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-eye mr-1"></i> {{ rand(100, 2000) }} views
                                </span>
                                <a href="{{ route('travel-guides.show', ['paris', 'tokyo', 'new-york', 'london', 'rome', 'barcelona'][rand(0,5)]) }}" class="text-red-500 font-bold hover:text-red-600">Read more →</a>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="my-8">
            {{ $guides ?? '' }}
        </div>
    </div>
</div>
@endsection

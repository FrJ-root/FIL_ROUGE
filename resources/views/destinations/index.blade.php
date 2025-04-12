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
        <!-- Hero Section -->
        <div class="relative h-[500px] overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-black/70"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white px-4 max-w-4xl">
                    <h1 class="text-5xl md:text-6xl font-bold mb-4">Explore Amazing Destinations</h1>
                    <p class="text-xl md:text-2xl mb-8">Discover beautiful places around the world and plan your next adventure</p>
                    <div class="relative max-w-2xl mx-auto">
                        <form action="{{ url('/search') }}" method="GET" class="flex">
                            <input 
                                type="text" 
                                name="query" 
                                placeholder="Search for a destination..." 
                                class="w-full px-6 py-4 rounded-l-lg border-0 focus:outline-none focus:ring-2 focus:ring-red-500 text-gray-800"
                            >
                            <button type="submit" class="bg-red-500 text-white px-6 py-4 rounded-r-lg hover:bg-red-600 transition-colors">
                                <i class="fas fa-search mr-2"></i> Search
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-12">
            <!-- Featured Destinations -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Featured Destinations</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredDestinations as $destination)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow group">
                        <a href="{{ route('destinations.show', $destination->slug) }}" class="block relative h-64 overflow-hidden">
                            <img 
                                src="{{ getDestinationImageUrl($destination->name, $destination->location) }}" 
                                alt="{{ $destination->name }}" 
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <h3 class="text-2xl font-bold">{{ $destination->name }}</h3>
                                <p class="text-sm">{{ $destination->location }}</p>
                            </div>
                        </a>
                        <div class="p-4">
                            <p class="text-gray-600 mb-3 line-clamp-3">{{ $destination->description }}</p>
                            <a href="{{ route('destinations.show', $destination->slug) }}" class="text-red-500 font-semibold hover:text-red-600 transition-colors inline-flex items-center">
                                Explore <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- Destinations by Region -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Explore by Region</h2>
                
                <div class="space-y-8">
                    @foreach($allDestinations as $region => $destinations)
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $region }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($destinations as $destination)
                            <a href="{{ route('destinations.show', $destination->slug) }}" class="group">
                                <div class="relative h-48 rounded-lg overflow-hidden">
                                    <img 
                                        src="{{ getDestinationImageUrl($destination->name, $destination->location) }}" 
                                        alt="{{ $destination->name }}" 
                                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                                        <h4 class="text-lg font-bold">{{ $destination->name }}</h4>
                                        <p class="text-xs">{{ $destination->location }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- Categories Section -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Explore by Category</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($categories as $category)
                    <a href="#" class="group">
                        <div class="relative h-32 rounded-lg overflow-hidden">
                            <img 
                                src="{{ asset('storage/images/categories/' . $category->image) }}" 
                                alt="{{ $category->name }}" 
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                onerror="this.src='{{ asset('storage/images/default-category.jpg') }}'"
                            >
                            <div class="absolute inset-0 bg-black/50 group-hover:bg-black/40 transition-colors"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-white">
                                <h4 class="text-xl font-bold">{{ $category->name }}</h4>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>

            <!-- Travel Tips -->
            <section>
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Travel Tips & Inspiration</h2>
                <div class="bg-gray-50 rounded-2xl p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Planning Your Next Trip</h3>
                            <p class="text-gray-600 mb-4">Ready to explore the world but not sure where to start? Our travel experts have compiled their best tips to help you plan the perfect trip:</p>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Research the best time to visit your destination</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Book accommodations in advance for better rates</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Check visa requirements and travel restrictions</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Consider local transportation options</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Pack according to local weather and cultural expectations</span>
                                </li>
                            </ul>
                            <a href="#" class="inline-block mt-4 text-red-500 font-semibold hover:text-red-600 transition-colors">
                                Read more travel tips <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <div class="relative h-64 md:h-auto rounded-lg overflow-hidden">
                            <img 
                                src="{{ asset('storage/images/travel-planning.jpg') }}" 
                                alt="Travel Planning" 
                                class="w-full h-full object-cover"
                                onerror="this.src='{{ asset('storage/images/default-travel-tip.jpg') }}'"
                            >
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

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

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
        <div class="relative h-[500px] overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center" 
                style="background-image: url('{{ getDestinationImageUrl($destination->name, $destination->location) }}');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-black/70"></div>
            <div class="absolute inset-0 flex flex-col justify-end p-8">
                <div class="container mx-auto">
                    <a href="{{ route('destinations.index') }}" class="text-white/80 hover:text-white mb-4 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> All Destinations
                    </a>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">{{ $destination->name }}</h1>
                    <p class="text-xl text-white/90 mb-4">{{ $destination->location }}</p>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">About {{ $destination->name }}</h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 mb-6">{{ $destination->description }}</p>
                            
                            <div class="h-64 bg-gray-200 rounded-lg overflow-hidden mb-6">
                                <div id="map" class="w-full h-full"></div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Top Things to Do</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">Explore Local Landmarks</h4>
                                    <p class="text-gray-600 text-sm">Visit the iconic landmarks and cultural sites that make {{ $destination->name }} unique.</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">Sample Local Cuisine</h4>
                                    <p class="text-gray-600 text-sm">Try the local delicacies and traditional dishes that are popular in {{ $destination->name }}.</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">Visit Markets & Shops</h4>
                                    <p class="text-gray-600 text-sm">Browse the local markets for unique souvenirs and authentic local products.</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-bold mb-2">Nature & Outdoor Activities</h4>
                                    <p class="text-gray-600 text-sm">Experience the natural beauty and outdoor adventures available around {{ $destination->name }}.</p>
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Best Time to Visit</h3>
                            <p class="text-gray-700 mb-2">The ideal time to visit {{ $destination->name }} typically depends on what activities you're interested in:</p>
                            <div class="overflow-x-auto mb-6">
                                <table class="min-w-full bg-white border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2 bg-gray-50 text-left">Season</th>
                                            <th class="border border-gray-300 px-4 py-2 bg-gray-50 text-left">Months</th>
                                            <th class="border border-gray-300 px-4 py-2 bg-gray-50 text-left">Weather</th>
                                            <th class="border border-gray-300 px-4 py-2 bg-gray-50 text-left">Highlights</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">High Season</td>
                                            <td class="border border-gray-300 px-4 py-2">June to August</td>
                                            <td class="border border-gray-300 px-4 py-2">Warm and sunny</td>
                                            <td class="border border-gray-300 px-4 py-2">Outdoor activities, festivals</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">Shoulder Season</td>
                                            <td class="border border-gray-300 px-4 py-2">April to May, September to October</td>
                                            <td class="border border-gray-300 px-4 py-2">Mild, occasional rain</td>
                                            <td class="border border-gray-300 px-4 py-2">Fewer crowds, better prices</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">Low Season</td>
                                            <td class="border border-gray-300 px-4 py-2">November to March</td>
                                            <td class="border border-gray-300 px-4 py-2">Cooler, potential for rain</td>
                                            <td class="border border-gray-300 px-4 py-2">Best deals, cultural experiences</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    @if($relatedTrips->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Related Trips</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($relatedTrips as $trip)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="h-36 bg-gray-200 relative">
                                    @php
                                        $imageUrl = $trip->cover_picture 
                                            ? asset('storage/images/trips/' . $trip->cover_picture)
                                            : asset('storage/images/default-trip.jpg');
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $trip->destination }}" class="w-full h-full object-cover">
                                    <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/70 to-transparent text-white">
                                        <span class="font-bold text-sm">{{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-800">{{ $trip->destination }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">
                                        <i class="far fa-calendar-alt mr-1"></i> 
                                        {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days
                                    </p>
                                    <a href="{{ route('trips.show', $trip->id) }}" class="text-red-500 hover:text-red-600 font-medium text-sm">
                                        View Details <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Quick Information</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-globe text-red-500 mt-1 mr-3 w-5"></i>
                                <div>
                                    <span class="font-bold">Country:</span>
                                    <span class="text-gray-700">{{ $destination->location }}</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-language text-red-500 mt-1 mr-3 w-5"></i>
                                <div>
                                    <span class="font-bold">Languages:</span>
                                    <span class="text-gray-700">Local language, English in tourist areas</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-money-bill-wave text-red-500 mt-1 mr-3 w-5"></i>
                                <div>
                                    <span class="font-bold">Currency:</span>
                                    <span class="text-gray-700">Local currency (check exchange rates)</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-plug text-red-500 mt-1 mr-3 w-5"></i>
                                <div>
                                    <span class="font-bold">Power:</span>
                                    <span class="text-gray-700">Standard outlets (may require adapter)</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-plane-departure text-red-500 mt-1 mr-3 w-5"></i>
                                <div>
                                    <span class="font-bold">Airport:</span>
                                    <span class="text-gray-700">International airport available</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Plan Your Trip</h3>
                        <p class="text-gray-600 mb-4">Ready to explore {{ $destination->name }}? Create your custom trip now!</p>
                        
                        <a href="{{ route('trips.create') }}" class="block bg-red-500 text-white text-center py-3 px-4 rounded-lg hover:bg-red-600 transition-colors mb-4">
                            <i class="fas fa-plane-departure mr-2"></i> Create Trip
                        </a>
                        
                        <div class="text-gray-600 text-sm">
                            <p class="mb-2">Don't wait - start planning your adventure today!</p>
                            <p>Our trip planner helps you create the perfect itinerary for exploring {{ $destination->name }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
        
        const destinationName = "{{ $destination->name }}, {{ $destination->location }}";
        initMap(destinationName);
    });
    
    function initMap(location) {
        const map = L.map('map').setView([0, 0], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    
                    map.setView([lat, lon], 10);
                    
                    const marker = L.marker([lat, lon]).addTo(map);
                    marker.bindPopup(`<b>${location}</b>`).openPopup();
                } else {
                    console.warn(`Could not geocode location: ${location}`);
                }
            })
            .catch(error => {
                console.error('Geocoding error:', error);
            });
    }
</script>
@endpush

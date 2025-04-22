@extends('layouts.app')

@section('content')
    @include('components.sidebar')
    <div 
        x-data="{ sidebarCollapsed: true, mapFiltersOpen: false }"
        @sidebar-state-changed.window="sidebarCollapsed = $event.detail.isCollapsed"
        :class="{'md:ml-64': !sidebarCollapsed, 'md:ml-16': sidebarCollapsed}"
        class="transition-all duration-300" 
        id="main-content"
    >
        <div class="container-fluid p-0">
            <div class="relative h-screen">
                <!-- Hero Section -->
                <div class="absolute top-0 left-0 right-0 z-30 bg-gradient-to-b from-gray-900/80 to-transparent h-64 pointer-events-none">
                    <div class="container mx-auto px-4 pt-20">
                        <h1 class="text-4xl font-bold text-white mb-2 drop-shadow-lg">Interactive Travel Map</h1>
                        <p class="text-xl text-white/90 max-w-2xl drop-shadow-md">Explore destinations around the world, discover hotels, and plan your next adventure</p>
                    </div>
                </div>
                
                <!-- Map Controls & Filters -->
                <div class="absolute top-16 right-4 z-20 flex flex-col items-end space-y-2">
                    <button @click="mapFiltersOpen = !mapFiltersOpen" class="bg-white p-3 rounded-full shadow-lg hover:bg-gray-50 transition-all">
                        <i class="fas" :class="mapFiltersOpen ? 'fa-times text-red-500' : 'fa-sliders-h text-gray-700'"></i>
                    </button>
                    
                    <div x-show="mapFiltersOpen" x-transition class="bg-white rounded-lg shadow-lg p-4 w-72">
                        <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-filter text-red-500 mr-2"></i> Map Filters
                        </h3>
                        
                        <div class="space-y-3">
                            <!-- Map Type Selector -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Map Style</label>
                                <select id="map-style-selector" class="w-full rounded border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200">
                                    <option value="streets">Streets</option>
                                    <option value="outdoors">Outdoors</option>
                                    <option value="satellite">Satellite</option>
                                    <option value="dark">Dark Mode</option>
                                </select>
                            </div>
                            
                            <!-- Category Filters -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Show Places</label>
                                <div class="space-y-1">
                                    <label class="flex items-center">
                                        <input type="checkbox" id="show-destinations" class="rounded text-red-500 focus:ring-red-500" checked>
                                        <span class="ml-2 text-sm">Destinations</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" id="show-hotels" class="rounded text-blue-500 focus:ring-blue-500" checked>
                                        <span class="ml-2 text-sm">Hotels</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" id="show-attractions" class="rounded text-yellow-500 focus:ring-yellow-500">
                                        <span class="ml-2 text-sm">Attractions</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Region Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                                <select id="region-selector" class="w-full rounded border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200">
                                    <option value="all">All Regions</option>
                                    <option value="europe">Europe</option>
                                    <option value="asia">Asia</option>
                                    <option value="africa">Africa</option>
                                    <option value="north-america">North America</option>
                                    <option value="south-america">South America</option>
                                    <option value="oceania">Oceania</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Map Legend -->
                <div class="absolute bottom-6 left-4 z-20 bg-white/90 backdrop-blur-sm p-3 rounded-lg shadow-lg max-w-xs">
                    <h4 class="font-bold text-sm text-gray-800 mb-2">Map Legend</h4>
                    <div class="space-y-1 text-xs">
                        <div class="flex items-center">
                            <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center text-white text-xs">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="ml-2">Popular Destinations</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <span class="ml-2">Hotels & Accommodations</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 rounded-full bg-yellow-500 flex items-center justify-center text-white text-xs">
                                <i class="fas fa-monument"></i>
                            </div>
                            <span class="ml-2">Attractions & Landmarks</span>
                        </div>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="absolute top-36 left-4 right-4 md:left-auto md:right-4 md:w-72 z-20">
                    <div class="relative">
                        <input 
                            id="map-search" 
                            type="text" 
                            placeholder="Search for locations..." 
                            value="{{ $searchTerm ?? '' }}"
                            class="w-full pl-10 pr-4 py-2 rounded-lg shadow-lg border-0 focus:ring-2 focus:ring-red-500"
                        >
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button id="search-button" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Popular Destinations Carousel -->
                <div class="absolute bottom-24 right-4 left-4 md:right-4 md:left-auto md:w-72 z-20">
                    <div class="bg-white/90 backdrop-blur-sm p-3 rounded-lg shadow-lg">
                        <h3 class="font-bold text-gray-800 mb-2 text-sm flex items-center">
                            <i class="fas fa-fire text-red-500 mr-2"></i> Popular Destinations
                        </h3>
                        <div class="overflow-x-auto pb-2 flex space-x-2 scrollbar-thin">
                            @foreach($destinations->take(5) as $destination)
                            <div class="flex-shrink-0 w-32 cursor-pointer hover:opacity-90 transition-opacity destination-card" 
                                 data-name="{{ $destination->name }}, {{ $destination->location }}">
                                <div class="h-20 rounded-lg bg-cover bg-center relative" 
                                     style="background-image: url('{{ getDestinationImageUrl($destination->name, $destination->location) }}')">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent rounded-lg"></div>
                                    <div class="absolute bottom-0 p-1 text-white font-medium text-xs">
                                        {{ $destination->name }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Map container -->
                <div id="map" class="w-full h-full" style="min-height: calc(100vh - 4rem);"></div>
                
                <!-- Map Info Panel (hidden by default) -->
                <div id="info-panel" class="hidden absolute bottom-10 md:bottom-auto md:top-36 md:right-4 left-1/2 md:left-auto transform -translate-x-1/2 md:translate-x-0 z-20 bg-white rounded-lg shadow-lg p-4 w-11/12 md:w-80 max-h-96 overflow-y-auto">
                    <button onclick="closeInfoPanel()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 bg-white rounded-full h-6 w-6 flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </button>
                    
                    <div id="info-image" class="h-40 bg-cover bg-center rounded-lg mb-3 relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-lg"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-3">
                            <h3 id="info-title" class="text-xl font-bold text-white drop-shadow-sm"></h3>
                            <p id="info-subtitle" class="text-white/90 text-sm flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i> <span></span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-3 space-y-2">
                        <p id="info-description" class="text-gray-600 text-sm"></p>
                        
                        <div id="info-details" class="border-t border-gray-100 pt-2 mt-2">
                            <!-- Dynamic details will be inserted here -->
                        </div>
                    </div>
                    
                    <div class="flex justify-between">
                        <a id="info-link" href="#" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors inline-block text-sm">
                            View Details
                        </a>
                        <button id="info-directions" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors inline-block text-sm">
                            <i class="fas fa-directions mr-1"></i> Directions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet Marker Cluster CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

<style>
    #map {
        height: calc(100vh - 4rem);
        width: 100%;
        z-index: 1;
    }
    
    .custom-map-control {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0,0,0,.3);
        font-family: 'Poppins', sans-serif;
        margin: 10px;
        padding: 5px 10px;
        font-size: 14px;
        cursor: pointer;
        z-index: 1000;
    }
    
    .custom-map-control:hover {
        background-color: #f0f0f0;
    }
    
    /* Leaflet popup customization */
    .leaflet-popup-content-wrapper {
        border-radius: 8px;
        padding: 0;
    }
    
    .leaflet-popup-content {
        margin: 0;
        padding: 10px;
    }
    
    /* Custom marker cluster styles */
    .marker-cluster-small {
        background-color: rgba(239, 68, 68, 0.6);
    }
    .marker-cluster-small div {
        background-color: rgba(239, 68, 68, 0.8);
        color: white;
    }
    
    .marker-cluster-medium {
        background-color: rgba(239, 68, 68, 0.6);
    }
    .marker-cluster-medium div {
        background-color: rgba(239, 68, 68, 0.8);
        color: white;
    }
    
    .marker-cluster-large {
        background-color: rgba(239, 68, 68, 0.6);
    }
    .marker-cluster-large div {
        background-color: rgba(239, 68, 68, 0.8);
        color: white;
    }
    
    .scrollbar-thin::-webkit-scrollbar {
        height: 4px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    .pulse-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ef4444;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    .pulse-dot::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.6);
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    /* Animation for destination cards */
    .destination-card {
        transition: transform 0.3s ease;
    }
    
    .destination-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<!-- Leaflet Marker Cluster JS -->
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<script>
    let map;
    let destinationMarkers = [];
    let hotelMarkers = [];
    let attractionMarkers = [];
    let markersClusterGroup;
    let currentMapStyle = 'streets';
    let mapTileLayers = {};
    let searchMarker = null;
    
    // Initialize the map
    function initMap() {
        // Default center (world view)
        const defaultCenter = [20, 0];
        
        // Create the map with OpenStreetMap
        map = L.map('map', {
            center: defaultCenter,
            zoom: 3,
            minZoom: 2,
            maxZoom: 18,
            zoomControl: false // We'll add custom zoom controls
        });
        
        // Define available map styles
        mapTileLayers = {
            streets: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }),
            outdoors: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a>'
            }),
            satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            }),
            dark: L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd'
            })
        };
        
        // Add the default street tiles to map
        mapTileLayers.streets.addTo(map);
        
        // Create a marker cluster group
        markersClusterGroup = L.markerClusterGroup({
            showCoverageOnHover: false,
            spiderfyOnMaxZoom: true,
            disableClusteringAtZoom: 16,
            maxClusterRadius: 50
        });
        
        // Add the markers cluster group to the map
        map.addLayer(markersClusterGroup);
        
        // Add custom controls
        addCustomControls();
        
        // Add destinations markers
        addDestinationMarkers();
        
        // Add hotels markers
        addHotelMarkers();
        
        // Add attractions markers (these would normally come from your backend)
        addAttractionMarkers();
        
        // Set up search box
        setupSearchBox();
        
        // Set up map style selector
        setupMapStyleSelector();
        
        // Set up filter checkboxes
        setupFilterCheckboxes();
        
        // Set up region selector
        setupRegionSelector();
        
        // Set up popular destinations cards
        setupDestinationCards();
    }
    
    // Add destination markers
    function addDestinationMarkers() {
        const destinations = @json($destinations);
        
        destinations.forEach(destination => {
            // For demonstration, we'll geocode using a simple fetch request to Nominatim
            // In production, you might want to store latitude and longitude in your database
            geocodeAddress(destination.name + ', ' + destination.location, function(position) {
                if (position) {
                    // Create custom icon
                    const redIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="background-color: #ef4444; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                                 <i class="fas fa-map-marker-alt text-white"></i>
                                 <div class="pulse-dot"></div>
                               </div>`,
                        iconSize: [30, 30],
                        iconAnchor: [15, 15],
                        popupAnchor: [0, -15]
                    });
                    
                    // Create marker
                    const marker = L.marker([position.lat, position.lng], {
                        title: destination.name,
                        icon: redIcon,
                        type: 'destination',
                        region: getRegionFromLocation(destination.location)
                    });
                    
                    // Prepare detailed info for the destination
                    const destinationDetails = {
                        id: destination.id,
                        slug: destination.slug, // Add slug to the details
                        name: destination.name,
                        location: destination.location,
                        description: destination.description || `Explore the beautiful destination of ${destination.name} located in ${destination.location}.`,
                        image: `https://source.unsplash.com/800x600/?${destination.name},${destination.location}`,
                        type: 'destination',
                        details: {
                            // Additional details to display
                            'Best time to visit': 'All year round',
                            'Language': 'Local + English',
                            'Popular for': 'Culture, Sightseeing'
                        }
                    };
                    
                    // Store data with the marker
                    marker.destinationData = destinationDetails;
                    
                    // Add click event
                    marker.on('click', function() {
                        showInfoPanel(this.destinationData);
                    });
                    
                    // Add to cluster group
                    markersClusterGroup.addLayer(marker);
                    
                    // Keep reference
                    destinationMarkers.push(marker);
                }
            });
        });
    }
    
    // Add hotel markers
    function addHotelMarkers() {
        const hotels = @json($hotels);
        
        hotels.forEach(hotel => {
            if (hotel.latitude && hotel.longitude) {
                // Create custom icon
                const blueIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="background-color: #3b82f6; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                             <i class="fas fa-hotel text-white"></i>
                           </div>`,
                    iconSize: [30, 30],
                    iconAnchor: [15, 15],
                    popupAnchor: [0, -15]
                });
                
                // Create marker
                const marker = L.marker([hotel.latitude, hotel.longitude], {
                    title: hotel.name,
                    icon: blueIcon,
                    type: 'hotel',
                    region: getRegionFromLocation(hotel.country)
                });
                
                // Prepare hotel details
                const hotelDetails = {
                    id: hotel.id,
                    name: hotel.name,
                    location: `${hotel.city}, ${hotel.country}`,
                    description: hotel.description || `${hotel.star_rating}-star hotel in ${hotel.city}, ${hotel.country}.`,
                    image: hotel.image ? `{{ asset('storage/images/hotels') }}/${hotel.image}` : `{{ asset('images/default-hotel.jpg') }}`,
                    type: 'hotel',
                    details: {
                        'Stars': '★'.repeat(hotel.star_rating) + '☆'.repeat(5 - hotel.star_rating),
                        'Price': `$${hotel.price_per_night} per night`,
                        'Amenities': formatAmenities(hotel.amenities)
                    }
                };
                
                // Store data with the marker
                marker.hotelData = hotelDetails;
                
                // Add click event
                marker.on('click', function() {
                    showInfoPanel(this.hotelData);
                });
                
                // Add to cluster group
                markersClusterGroup.addLayer(marker);
                
                // Keep reference
                hotelMarkers.push(marker);
            }
        });
    }
    
    // Add attraction markers (demo data)
    function addAttractionMarkers() {
        const attractions = [
            {
                name: "Eiffel Tower",
                location: "Paris, France",
                description: "Iconic iron tower in Paris, a symbol of France and one of the world's most recognizable landmarks.",
                coordinates: [48.8584, 2.2945],
                image: "{{ asset('storage/images/attractions/eiffel-tower.jpg') }}"
            },
            {
                name: "Colosseum",
                location: "Rome, Italy",
                description: "Ancient amphitheater in the center of Rome, a masterpiece of Roman engineering and architecture.",
                coordinates: [41.8902, 12.4922],
                image: "{{ asset('storage/images/attractions/colosseum.jpg') }}"
            },
            {
                name: "Statue of Liberty",
                location: "New York, USA",
                description: "Colossal statue on Liberty Island, a symbol of freedom and the United States.",
                coordinates: [40.6892, -74.0445],
                image: "{{ asset('storage/images/attractions/statue-of-liberty.jpg') }}"
            }
        ];
        
        attractions.forEach(attraction => {
            // Create custom icon
            const yellowIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="background-color: #eab308; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                         <i class="fas fa-monument text-white"></i>
                       </div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 15],
                popupAnchor: [0, -15]
            });
            
            // Create marker
            const marker = L.marker(attraction.coordinates, {
                title: attraction.name,
                icon: yellowIcon,
                type: 'attraction',
                region: getRegionFromLocation(attraction.location.split(', ')[1])
            });
            
            // Prepare attraction details
            const attractionDetails = {
                name: attraction.name,
                location: attraction.location,
                description: attraction.description,
                image: attraction.image,
                type: 'attraction',
                details: {
                    'Type': 'Landmark',
                    'Visiting hours': '9 AM - 5 PM',
                    'Entry fee': 'Varies'
                }
            };
            
            // Store data with the marker
            marker.attractionData = attractionDetails;
            
            // Add click event
            marker.on('click', function() {
                showInfoPanel(this.attractionData);
            });
            
            // Add to cluster group
            markersClusterGroup.addLayer(marker);
            
            // Keep reference
            attractionMarkers.push(marker);
        });
    }
    
    // Show info panel
    function showInfoPanel(itemData) {
        // Update the info panel with item data
        document.getElementById('info-title').textContent = itemData.name;
        document.getElementById('info-subtitle').querySelector('span').textContent = itemData.location;
        document.getElementById('info-description').textContent = itemData.description;
        
        // Set appropriate background image
        document.getElementById('info-image').style.backgroundImage = `url('${itemData.image}')`;
        
        // Clear previous details
        const detailsContainer = document.getElementById('info-details');
        detailsContainer.innerHTML = '';
        
        // Add details if they exist
        if (itemData.details) {
            Object.entries(itemData.details).forEach(([key, value]) => {
                const detailElement = document.createElement('div');
                detailElement.className = 'flex justify-between text-sm';
                detailElement.innerHTML = `
                    <span class="text-gray-500">${key}:</span>
                    <span class="font-medium">${value}</span>
                `;
                detailsContainer.appendChild(detailElement);
            });
        }
        
        // Set link based on item type
        const infoLink = document.getElementById('info-link');
        if (itemData.type === 'destination') {
            // Use slug instead of id for destinations
            infoLink.href = `{{ url('/destinations') }}/${itemData.slug}`;
            infoLink.textContent = 'View Destination';
        } else if (itemData.type === 'hotel') {
            infoLink.href = `{{ url('/hotels') }}/${itemData.id}`;
            infoLink.textContent = 'View Hotel';
        } else {
            infoLink.href = '#';
            infoLink.textContent = 'View Details';
        }
        
        // Set up directions button
        document.getElementById('info-directions').onclick = function() {
            const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(itemData.name + ' ' + itemData.location)}`;
            window.open(url, '_blank');
        };
        
        // Show the panel
        document.getElementById('info-panel').classList.remove('hidden');
    }
    
    // Close info panel
    function closeInfoPanel() {
        document.getElementById('info-panel').classList.add('hidden');
    }
    
    // Geocode address using OpenStreetMap Nominatim
    function geocodeAddress(address, callback) {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    callback({
                        lat: parseFloat(data[0].lat),
                        lng: parseFloat(data[0].lon)
                    });
                } else {
                    console.warn(`Could not geocode address: ${address}`);
                    callback(null);
                }
            })
            .catch(error => {
                console.error('Geocoding error:', error);
                callback(null);
            });
    }
    
    // Setup search box
    function setupSearchBox() {
        const input = document.getElementById('map-search');
        const searchButton = document.getElementById('search-button');
        
        const searchLocation = () => {
            const searchValue = input.value.trim();
            if (!searchValue) return;
            
            geocodeAddress(searchValue, function(position) {
                if (position) {
                    map.setView([position.lat, position.lng], 12);
                    
                    // Remove previous search marker if it exists
                    if (searchMarker) {
                        map.removeLayer(searchMarker);
                    }
                    
                    // Add a new search marker
                    const searchIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="background-color: #10b981; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                                 <i class="fas fa-search text-white"></i>
                               </div>`,
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    });
                    
                    searchMarker = L.marker([position.lat, position.lng], {
                        icon: searchIcon
                    }).addTo(map);
                    
                    // Add a popup with the search term
                    searchMarker.bindPopup(`<div class="text-center"><strong>${searchValue}</strong><br><span class="text-xs text-gray-500">Search result</span></div>`).openPopup();
                    
                    // Create animation
                    const searchAnimation = document.createElement('div');
                    searchAnimation.className = 'absolute w-full h-full';
                    searchAnimation.innerHTML = `
                        <div class="absolute inset-0 bg-green-500 opacity-30 rounded-full animate-ping"></div>
                    `;
                    
                    // Create a bounce animation
                    const marker = searchMarker.getElement();
                    if (marker) {
                        marker.classList.add('animate-bounce');
                        setTimeout(() => {
                            marker.classList.remove('animate-bounce');
                        }, 1000);
                    }
                } else {
                    alert('Location not found. Please try a different search term.');
                }
            });
        };
        
        // Search on button click
        searchButton.addEventListener('click', searchLocation);
        
        // Search on Enter key
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchLocation();
            }
        });
    }
    
    // Map style selector
    function setupMapStyleSelector() {
        const styleSelector = document.getElementById('map-style-selector');
        
        styleSelector.addEventListener('change', function() {
            const selectedStyle = this.value;
            
            // Remove current tile layer
            map.removeLayer(mapTileLayers[currentMapStyle]);
            
            // Add new tile layer
            map.addLayer(mapTileLayers[selectedStyle]);
            
            // Update current style reference
            currentMapStyle = selectedStyle;
        });
    }
    
    // Filter checkboxes
    function setupFilterCheckboxes() {
        const showDestinations = document.getElementById('show-destinations');
        const showHotels = document.getElementById('show-hotels');
        const showAttractions = document.getElementById('show-attractions');
        
        showDestinations.addEventListener('change', function() {
            toggleMarkerType('destination', this.checked);
        });
        
        showHotels.addEventListener('change', function() {
            toggleMarkerType('hotel', this.checked);
        });
        
        showAttractions.addEventListener('change', function() {
            toggleMarkerType('attraction', this.checked);
        });
    }
    
    // Region selector
    function setupRegionSelector() {
        const regionSelector = document.getElementById('region-selector');
        
        regionSelector.addEventListener('change', function() {
            const selectedRegion = this.value;
            
            // Reset the map if "all" is selected
            if (selectedRegion === 'all') {
                // Show all markers again
                [...destinationMarkers, ...hotelMarkers, ...attractionMarkers].forEach(marker => {
                    if (!markersClusterGroup.hasLayer(marker)) {
                        markersClusterGroup.addLayer(marker);
                    }
                });
                
                // Reset view to world view
                map.setView([20, 0], 3);
                return;
            }
            
            // Filter markers by the selected region
            [...destinationMarkers, ...hotelMarkers, ...attractionMarkers].forEach(marker => {
                const markerRegion = marker.options.region;
                
                if (markerRegion === selectedRegion) {
                    if (!markersClusterGroup.hasLayer(marker)) {
                        markersClusterGroup.addLayer(marker);
                    }
                } else {
                    markersClusterGroup.removeLayer(marker);
                }
            });
            
            // Find bounds for the selected region
            const regionMarkers = [...destinationMarkers, ...hotelMarkers, ...attractionMarkers]
                .filter(marker => marker.options.region === selectedRegion);
            
            if (regionMarkers.length > 0) {
                const latLngs = regionMarkers.map(marker => marker.getLatLng());
                const bounds = L.latLngBounds(latLngs);
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        });
    }
    
    // Toggle marker visibility by type
    function toggleMarkerType(type, visible) {
        let markers;
        
        if (type === 'destination') {
            markers = destinationMarkers;
        } else if (type === 'hotel') {
            markers = hotelMarkers;
        } else if (type === 'attraction') {
            markers = attractionMarkers;
        }
        
        if (markers) {
            markers.forEach(marker => {
                if (visible) {
                    if (!markersClusterGroup.hasLayer(marker)) {
                        markersClusterGroup.addLayer(marker);
                    }
                } else {
                    markersClusterGroup.removeLayer(marker);
                }
            });
        }
    }
    
    // Get region from location
    function getRegionFromLocation(location) {
        const europeCountries = ['France', 'Italy', 'Spain', 'Germany', 'UK', 'Greece', 'Portugal', 'Switzerland'];
        const asiaCountries = ['Japan', 'China', 'Thailand', 'Indonesia', 'India', 'Vietnam', 'Singapore'];
        const africaCountries = ['Morocco', 'Egypt', 'Kenya', 'South Africa', 'Tanzania'];
        const northAmericaCountries = ['USA', 'Canada', 'Mexico'];
        const southAmericaCountries = ['Brazil', 'Argentina', 'Peru', 'Colombia', 'Chile'];
        const oceaniaCountries = ['Australia', 'New Zealand'];
        
        if (europeCountries.includes(location)) return 'europe';
        if (asiaCountries.includes(location)) return 'asia';
        if (africaCountries.includes(location)) return 'africa';
        if (northAmericaCountries.includes(location)) return 'north-america';
        if (southAmericaCountries.includes(location)) return 'south-america';
        if (oceaniaCountries.includes(location)) return 'oceania';
        
        return 'other';
    }
    
    // Format amenities from JSON to readable string
    function formatAmenities(amenities) {
        if (!amenities) return 'None listed';
        
        // If it's a string that looks like a JSON array
        if (typeof amenities === 'string' && (amenities.startsWith('[') || amenities.startsWith('{'))) {
            try {
                const parsed = JSON.parse(amenities);
                if (Array.isArray(parsed)) {
                    return parsed.slice(0, 3).join(', ') + (parsed.length > 3 ? '...' : '');
                }
                return Object.keys(parsed).slice(0, 3).join(', ') + (Object.keys(parsed).length > 3 ? '...' : '');
            } catch (e) {
                return amenities;
            }
        }
        
        return amenities;
    }
    
    // Setup destination cards
    function setupDestinationCards() {
        const cards = document.querySelectorAll('.destination-card');
        
        cards.forEach(card => {
            card.addEventListener('click', function() {
                const destinationName = this.getAttribute('data-name');
                
                if (destinationName) {
                    geocodeAddress(destinationName, function(position) {
                        if (position) {
                            map.setView([position.lat, position.lng], 12);
                            
                            // Locate the destination marker
                            const relevantMarker = destinationMarkers.find(marker => 
                                marker.options.title === destinationName.split(',')[0].trim());
                            
                            // If we found a matching marker, show its info
                            if (relevantMarker) {
                                // Create a bounce animation for the marker
                                const marker = relevantMarker.getElement();
                                if (marker) {
                                    marker.classList.add('animate-bounce');
                                    setTimeout(() => {
                                        marker.classList.remove('animate-bounce');
                                    }, 1000);
                                }
                                
                                // Show the info panel
                                showInfoPanel(relevantMarker.destinationData);
                            }
                        }
                    });
                }
            });
        });
    }
    
    // Add custom controls
    function addCustomControls() {
        // Add zoom controls in a better position
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);
        
        // Create a reset view control
        const resetViewControl = L.control({ position: 'bottomright' });
        resetViewControl.onAdd = function(map) {
            const div = L.DomUtil.create('div', 'custom-map-control');
            div.innerHTML = '<i class="fas fa-globe-americas"></i>';
            div.title = 'Reset world view';
            
            div.onclick = function() {
                map.setView([20, 0], 3);
            };
            
            return div;
        };
        resetViewControl.addTo(map);
        
        // Create a locate me control
        const locateMeControl = L.control({ position: 'bottomright' });
        locateMeControl.onAdd = function(map) {
            const div = L.DomUtil.create('div', 'custom-map-control');
            div.innerHTML = '<i class="fas fa-location-arrow"></i>';
            div.title = 'Find my location';
            
            div.onclick = function() {
                map.locate({setView: true, maxZoom: 16});
                
                map.on('locationfound', function(e) {
                    // Remove previous location marker if it exists
                    if (window.locationMarker) {
                        map.removeLayer(window.locationMarker);
                    }
                    
                    // Create custom icon
                    const locationIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="background-color: #3b82f6; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5);"></div>`,
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    });
                    
                    // Add marker at user's location
                    window.locationMarker = L.marker(e.latlng, {icon: locationIcon}).addTo(map);
                    window.locationMarker.bindPopup("You are here!").openPopup();
                    
                    // Add accuracy circle
                    window.locationCircle = L.circle(e.latlng, {
                        radius: e.accuracy / 2,
                        weight: 1,
                        color: '#3b82f6',
                        fillColor: '#93c5fd',
                        fillOpacity: 0.2
                    }).addTo(map);
                });
                
                map.on('locationerror', function(e) {
                    alert("Location access denied or not available.");
                });
            };
            
            return div;
        };
        locateMeControl.addTo(map);
        
        // Create a fullscreen control
        const fullscreenControl = L.control({ position: 'bottomright' });
        fullscreenControl.onAdd = function(map) {
            const div = L.DomUtil.create('div', 'custom-map-control');
            div.innerHTML = '<i class="fas fa-expand"></i>';
            div.title = 'Toggle fullscreen';
            
            div.onclick = function() {
                const mapElement = document.getElementById('map');
                
                if (
                    document.fullscreenElement ||
                    document.webkitFullscreenElement ||
                    document.mozFullScreenElement ||
                    document.msFullscreenElement
                ) {
                    // Exit fullscreen
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                    div.innerHTML = '<i class="fas fa-expand"></i>';
                } else {
                    // Enter fullscreen
                    if (mapElement.requestFullscreen) {
                        mapElement.requestFullscreen();
                    } else if (mapElement.webkitRequestFullscreen) {
                        mapElement.webkitRequestFullscreen();
                    } else if (mapElement.mozRequestFullScreen) {
                        mapElement.mozRequestFullScreen();
                    } else if (mapElement.msRequestFullscreen) {
                        mapElement.msRequestFullscreen();
                    }
                    div.innerHTML = '<i class="fas fa-compress"></i>';
                }
                
                // Need to invalidate size after fullscreen change
                setTimeout(() => {
                    map.invalidateSize();
                }, 100);
            };
            
            return div;
        };
        fullscreenControl.addTo(map);
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize map
        initMap();
        
        // Auto-search if searchTerm is provided
        const searchTerm = "{{ $searchTerm ?? '' }}";
        if (searchTerm) {
            document.getElementById('map-search').value = searchTerm;
            setTimeout(() => {
                document.getElementById('search-button').click();
            }, 1000);
        }
        
        // Sidebar observer
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
        
        // Handle map resize when sidebar changes or window resizes
        window.addEventListener('resize', function() {
            if (map) {
                map.invalidateSize();
            }
        });
    });
</script>
@endpush

@extends('layouts.app')

@section('content')
<div class="pt-24">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Hotels</h1>
        
        <!-- Search Filters -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <form>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Destination</label>
                        <input type="text" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-500" placeholder="City or Hotel name">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Check-in</label>
                        <input type="date" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Check-out</label>
                        <input type="date" class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition-colors duration-300 w-full">Search Hotels</button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Hotel Listings -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Hotel Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Hotel" class="w-full h-48 object-cover">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-bold mb-2 text-gray-800">Grand Hotel</h2>
                        <div class="flex items-center">
                            <span class="text-yellow-500"><i class="fas fa-star"></i></span>
                            <span class="ml-1 text-gray-700 font-bold">4.8</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Downtown, City Center</p>
                    <p class="text-gray-600 mb-4">Luxury hotel with panoramic views and premium amenities.</p>
                    <div class="flex justify-between items-center">
                        <p class="text-green-600 font-bold">$199<span class="text-gray-500 text-sm font-normal"> / night</span></p>
                        <a href="#" class="text-red-500 font-bold hover:text-red-600">View Details</a>
                    </div>
                </div>
            </div>
            
            <!-- More Hotel Cards -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Hotel" class="w-full h-48 object-cover">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-bold mb-2 text-gray-800">Seaside Resort</h2>
                        <div class="flex items-center">
                            <span class="text-yellow-500"><i class="fas fa-star"></i></span>
                            <span class="ml-1 text-gray-700 font-bold">4.6</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Beach Front</p>
                    <p class="text-gray-600 mb-4">Beautiful beach resort with spa and infinity pool.</p>
                    <div class="flex justify-between items-center">
                        <p class="text-green-600 font-bold">$249<span class="text-gray-500 text-sm font-normal"> / night</span></p>
                        <a href="#" class="text-red-500 font-bold hover:text-red-600">View Details</a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Hotel" class="w-full h-48 object-cover">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-bold mb-2 text-gray-800">Mountain Lodge</h2>
                        <div class="flex items-center">
                            <span class="text-yellow-500"><i class="fas fa-star"></i></span>
                            <span class="ml-1 text-gray-700 font-bold">4.7</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-2"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Mountain View</p>
                    <p class="text-gray-600 mb-4">Cozy retreat with stunning mountain views and hiking trails.</p>
                    <div class="flex justify-between items-center">
                        <p class="text-green-600 font-bold">$179<span class="text-gray-500 text-sm font-normal"> / night</span></p>
                        <a href="#" class="text-red-500 font-bold hover:text-red-600">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('traveller.layouts.master')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="py-4">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>
            <p class="mt-1 text-gray-600">Here's an overview of your travel plans and booking status.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Upcoming Trips</p>
                        <p class="text-lg font-semibold text-gray-800">{{ isset($upcomingTrips) ? count($upcomingTrips) : 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed Trips</p>
                        <p class="text-lg font-semibold text-gray-800">{{ isset($pastTrips) ? count($pastTrips) : 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 mr-4">
                        <svg class="h-6 w-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Reward Points</p>
                        <p class="text-lg font-semibold text-gray-800">{{ isset($traveller) ? ($traveller->reward_points ?? 0) : 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Upcoming Trips</h3>
            </div>
            
            <div class="divide-y divide-gray-200">
                @if(isset($upcomingTrips) && count($upcomingTrips) > 0)
                    @foreach($upcomingTrips as $trip)
                        <div class="px-6 py-4 flex items-center">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-blue-600 truncate">{{ $trip->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($trip->start_date)->format('M d, Y') }} - 
                                    {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="#" class="font-medium text-blue-600 hover:text-blue-500 text-sm">View details</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="px-6 py-4">
                        <p class="text-gray-500 text-sm">You don't have any upcoming trips.</p>
                        <a href="#" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Browse Destinations
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recommended for You</h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm border border-gray-200">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                        <div class="p-4">
                            <h4 class="font-medium text-gray-900">Beach Paradise</h4>
                            <p class="text-xs text-gray-500 mt-1">7 days | From $899</p>
                            <a href="#" class="mt-2 block text-sm text-blue-600 font-medium">Learn more →</a>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm border border-gray-200">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                        <div class="p-4">
                            <h4 class="font-medium text-gray-900">Urban Discovery</h4>
                            <p class="text-xs text-gray-500 mt-1">4 days | From $599</p>
                            <a href="#" class="mt-2 block text-sm text-blue-600 font-medium">Learn more →</a>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm border border-gray-200">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1502602898657-3e91760cbb34?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60')"></div>
                        <div class="p-4">
                            <h4 class="font-medium text-gray-900">Mountain Retreat</h4>
                            <p class="text-xs text-gray-500 mt-1">5 days | From $749</p>
                            <a href="#" class="mt-2 block text-sm text-blue-600 font-medium">Learn more →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
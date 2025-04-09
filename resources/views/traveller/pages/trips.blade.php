@extends('traveller.layouts.trips')

@section('trip_content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Your Trips</h3>
        </div>
        
        <div class="divide-y divide-gray-200">
            @if(isset($allTrips) && count($allTrips) > 0)
                @foreach($allTrips as $trip)
                    <div class="px-6 py-4 flex items-center trip-card">
                        <div class="h-12 w-12 rounded-md bg-blue-100 flex items-center justify-center mr-4">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-blue-600 truncate">{{ $trip->name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($trip->start_date)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                            </p>
                            <div class="mt-1">
                                @if(\Carbon\Carbon::parse($trip->start_date)->isFuture())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Upcoming
                                    </span>
                                @elseif(\Carbon\Carbon::parse($trip->end_date)->isPast())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        In Progress
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500 text-sm">View details</a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="px-6 py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No trips found</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't booked any trips yet.</p>
                    <div class="mt-6">
                        <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Browse Destinations
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

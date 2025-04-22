@extends('traveller.layouts.trips')

@section('trip_content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-blue-500 text-white border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium">Your Trips</h3>
            <a href="{{ route('trips.index') }}" class="text-sm px-4 py-2 bg-white text-blue-600 rounded-md hover:bg-blue-50 transition-colors">
                <i class="fas fa-search mr-1"></i> Explore More Trips
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 m-4 rounded">
                {{ session('info') }}
            </div>
        @endif

        <div class="flex items-center space-x-4 px-6 pt-4">
            <a href="{{ route('traveller.trips', ['status' => 'all']) }}" class="px-4 py-2 {{ $activeStatus === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-md transition-colors">
                All Trips
            </a>
            <a href="{{ route('traveller.trips', ['status' => 'completed']) }}" class="px-4 py-2 {{ $activeStatus === 'completed' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-md transition-colors">
                Completed
            </a>
            <a href="{{ route('traveller.trips', ['status' => 'cancelled']) }}" class="px-4 py-2 {{ $activeStatus === 'cancelled' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-md transition-colors">
                Cancelled
            </a>
            <a href="{{ route('traveller.trips', ['status' => 'pending']) }}" class="px-4 py-2 {{ $activeStatus === 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-md transition-colors">
                Pending Payment
            </a>
        </div>
        
        <div class="divide-y divide-gray-200 mt-4">
            @if(isset($allTrips) && count($allTrips) > 0)
                @foreach($allTrips as $trip)
                    @php
                        $traveller = Auth::user()->traveller;
                        $paymentStatus = $traveller ? $traveller->payment_status : null;
                    @endphp
                    <div class="px-6 py-4 flex items-center trip-card">
                        <div class="h-16 w-16 rounded-md bg-cover bg-center mr-4" style="background-image: url('{{ $trip->cover_picture ? asset('storage/images/trip/' . $trip->cover_picture) : 'https://via.placeholder.com/150' }}')"></div>
                        <div class="min-w-0 flex-1">
                            <p class="text-lg font-medium text-blue-600 truncate">{{ $trip->destination }}</p>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($trip->start_date)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                            </p>
                            <div class="mt-1 flex space-x-2">
                                @if($paymentStatus === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Payment Required
                                    </span>
                                @elseif($paymentStatus === 'paid')
                                    @if(\Carbon\Carbon::parse($trip->start_date)->isFuture())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Upcoming
                                        </span>
                                    @elseif(\Carbon\Carbon::parse($trip->end_date)->isPast())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            In Progress
                                        </span>
                                    @endif
                                @elseif($paymentStatus === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex space-x-2">
                            @if($paymentStatus === 'pending')
                                <a href="{{ route('traveller.trips.payment', $trip->id) }}" class="font-medium text-white bg-green-600 hover:bg-green-700 text-sm px-4 py-2 rounded-md transition-colors">
                                    Complete Payment
                                </a>
                            @endif
                            
                            <a href="{{ route('trips.show', $trip->id) }}" class="font-medium text-blue-600 hover:text-blue-500 text-sm px-4 py-2 border border-blue-600 rounded-md hover:bg-blue-50 transition-colors">
                                View details
                            </a>
                            
                            @if($paymentStatus !== 'cancelled')
                                <form action="{{ route('traveller.trips.remove', $trip->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="font-medium text-red-600 hover:text-red-500 text-sm px-4 py-2 border border-red-600 rounded-md hover:bg-red-50 transition-colors" onclick="return confirm('Are you sure you want to {{ $paymentStatus === 'paid' ? 'cancel' : 'remove' }} this trip?')">
                                        {{ $paymentStatus === 'paid' ? 'Cancel' : 'Remove' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="px-6 py-8 text-center">
                    @if($activeStatus === 'cancelled')
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No cancelled trips</h3>
                        <p class="mt-1 text-sm text-gray-500">You don't have any cancelled trips.</p>
                    @elseif($activeStatus === 'pending')
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No pending payments</h3>
                        <p class="mt-1 text-sm text-gray-500">You don't have any trips awaiting payment.</p>
                    @else
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No trips found</h3>
                        <p class="mt-1 text-sm text-gray-500">You haven't booked any trips yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('trips.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-search mr-2"></i> Browse Trips
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

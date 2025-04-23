@extends('traveller.layouts.trips')

@section('trip_content')
<div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
    <div class="px-6 py-4 bg-indigo-600 text-white flex justify-between">
        <h3 class="font-bold">My Trips</h3>
        
        <div>
            <a href="{{ route('trips.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 rounded-md text-sm font-medium hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-plus mr-2"></i> Explore More Trips
            </a>
        </div>
    </div>
    
    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif
        
        @if(session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <p>{{ session('info') }}</p>
                </div>
            </div>
        @endif

        @if(isset($pendingPaymentTrips) && $pendingPaymentTrips->isNotEmpty())
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
                <h3 class="text-xl font-bold text-yellow-800 mb-4 flex items-center">
                    <i class="fas fa-exclamation-circle text-yellow-600 mr-2"></i>
                    Trips Requiring Payment
                </h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                    @foreach($pendingPaymentTrips as $trip)
                        <div class="bg-white rounded-lg shadow-sm border border-yellow-100 overflow-hidden flex flex-col">
                            <div class="h-32 bg-cover bg-center" style="background-image: url('{{ $trip->cover_picture ? asset('storage/images/trip/' . $trip->cover_picture) : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}')">
                                <div class="h-full w-full bg-gradient-to-b from-transparent to-black/60 flex items-end p-3">
                                    <div>
                                        <h4 class="text-white font-bold">{{ $trip->destination }}</h4>
                                        <p class="text-white/80 text-xs">
                                            {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} - 
                                            {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 flex flex-col justify-between flex-grow">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar-day mr-1 text-yellow-600"></i>
                                        {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days
                                    </div>
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full inline-flex items-center">
                                        <i class="fas fa-clock mr-1"></i> Payment Pending
                                    </span>
                                </div>
                                <a href="{{ route('traveller.trips.payment', $trip->id) }}" 
                                   class="w-full bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 px-4 rounded-lg transition-colors font-medium flex items-center justify-center">
                                    <i class="fas fa-credit-card mr-2"></i> Complete Payment Now
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <p class="text-sm text-yellow-700">
                    <i class="fas fa-info-circle mr-1"></i> 
                    Please complete payment to confirm your trip booking. Unpaid bookings may be cancelled.
                </p>
            </div>
        @endif

        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('traveller.trips') }}" class="{{ $activeStatus == 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    All Trips
                </a>
                <a href="{{ route('traveller.trips', ['status' => 'pending']) }}" class="{{ $activeStatus == 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Pending Payment
                </a>
                <a href="{{ route('traveller.trips', ['status' => 'completed']) }}" class="{{ $activeStatus == 'completed' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Completed
                </a>
                <a href="{{ route('traveller.trips', ['status' => 'cancelled']) }}" class="{{ $activeStatus == 'cancelled' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Cancelled
                </a>
            </nav>
        </div>

        @if($allTrips->isEmpty())
            <div class="text-center py-12">
                @if($activeStatus == 'pending')
                    <div class="inline-block p-4 rounded-full bg-yellow-100 text-yellow-600 mb-4">
                        <i class="fas fa-wallet text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No pending payments</h3>
                @elseif($activeStatus == 'completed')
                    <div class="inline-block p-4 rounded-full bg-green-100 text-green-600 mb-4">
                        <i class="fas fa-check-circle text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No completed trips</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">
                        You haven't completed any trips yet. Your adventures will appear here after they're finished.
                    </p>
                @elseif($activeStatus == 'cancelled')
                    <div class="inline-block p-4 rounded-full bg-red-100 text-red-600 mb-4">
                        <i class="fas fa-times-circle text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No cancelled trips</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">
                        You don't have any cancelled trips.
                    </p>
                @else
                    <div class="inline-block p-4 rounded-full bg-indigo-100 text-indigo-500 mb-4">
                        <i class="fas fa-suitcase-rolling text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Your travel journal is empty</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">
                        You haven't booked any trips yet. Explore our available trips to start your adventure!
                    </p>
                @endif
                
                <a href="{{ route('trips.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                    Explore Trips
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($allTrips as $trip)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $trip->cover_picture ? asset('storage/images/trip/' . $trip->cover_picture) : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}')">
                            <div class="h-full w-full bg-gradient-to-b from-transparent to-black/60 flex items-end p-4">
                                <div>
                                    <h3 class="text-white text-xl font-bold">{{ $trip->destination }}</h3>
                                    <p class="text-white/80 text-sm">
                                        {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} - 
                                        {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            @php
                                $traveller = auth()->user()->traveller;
                                $paymentStatus = $traveller ? $traveller->payment_status : null;
                            @endphp
                            
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="flex items-center text-gray-700 mb-2">
                                        <i class="fas fa-clock text-indigo-500 mr-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-users text-indigo-500 mr-2"></i>
                                        <span>{{ $trip->travellers->count() }} travellers</span>
                                    </div>
                                </div>
                                
                                @if($paymentStatus === 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                        Payment Pending
                                    </span>
                                @elseif($paymentStatus === 'paid')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                        Confirmed
                                    </span>
                                @elseif($paymentStatus === 'cancelled')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                        Cancelled
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <a href="{{ route('trips.show', $trip->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                    View Trip Details
                                </a>
                                
                                @if($paymentStatus === 'pending')
                                    <a href="{{ route('traveller.trips.payment', $trip->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700">
                                        <i class="fas fa-credit-card mr-1"></i> Pay Now
                                    </a>
                                @elseif($paymentStatus === 'paid')
                                    <form action="{{ route('traveller.trips.remove', $trip->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-sm font-medium rounded hover:bg-red-200" onclick="return confirm('Are you sure you want to cancel this trip? This may be subject to cancellation fees.')">
                                            <i class="fas fa-times mr-1"></i> Cancel Trip
                                        </button>
                                    </form>
                                @elseif($paymentStatus === null)
                                    <a href="{{ route('traveller.trips.payment', $trip->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700">
                                        <i class="fas fa-credit-card mr-1"></i> Pay Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

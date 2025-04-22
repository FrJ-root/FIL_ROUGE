@extends('manager.layouts.manager')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-user text-blue-500 mr-2"></i> Traveller Details
        </h1>
        <a href="{{ route('manager.travellers') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="fas fa-arrow-left mr-1"></i> Back to Travellers
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Traveller Profile Header -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <div class="flex flex-col md:flex-row items-center md:items-start">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-white border-4 border-white shadow-md mb-4 md:mb-0 md:mr-6">
                    @if($traveller->user && $traveller->user->picture)
                        <img src="{{ asset('storage/' . $traveller->user->picture) }}" alt="{{ $traveller->user->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-blue-500 flex items-center justify-center">
                            <span class="text-white text-3xl font-bold">{{ $traveller->user ? substr($traveller->user->name, 0, 1) : '?' }}</span>
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{ $traveller->user ? $traveller->user->name : 'Unknown User' }}</h2>
                    <p class="text-blue-100">{{ $traveller->user ? $traveller->user->email : 'No email available' }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">
                            ID: #{{ $traveller->id }}
                        </span>
                        @if($traveller->trip)
                            <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                Active Trip
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Traveller Information -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Details -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Personal Information</h3>
                    <div class="space-y-3">
                        <div class="flex">
                            <span class="text-gray-500 font-medium w-32">Nationality:</span>
                            <span class="text-gray-800">{{ $traveller->nationality ?? 'Not specified' }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-500 font-medium w-32">Passport:</span>
                            <span class="text-gray-800">{{ $traveller->passport_number ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-500 font-medium w-32">Preferred:</span>
                            <span class="text-gray-800">{{ $traveller->prefered_destination ?? 'No preferences' }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-500 font-medium w-32">Payment:</span>
                            @if($traveller->payment_status === 'paid')
                                <span class="text-green-500 font-medium">Paid</span>
                            @elseif($traveller->payment_status === 'pending')
                                <span class="text-yellow-500 font-medium">Pending Payment</span>
                            @elseif($traveller->payment_status === 'cancelled')
                                <span class="text-red-500 font-medium">Cancelled</span>
                            @else
                                <span class="text-gray-500">No payment information</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Trip Details -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Trip Information</h3>
                    @if($traveller->trip)
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="text-gray-500 font-medium w-32">Destination:</span>
                                <span class="text-gray-800">{{ $traveller->trip->destination }}</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 font-medium w-32">Dates:</span>
                                <span class="text-gray-800">
                                    {{ \Carbon\Carbon::parse($traveller->trip->start_date)->format('M d, Y') }} - 
                                    {{ \Carbon\Carbon::parse($traveller->trip->end_date)->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 font-medium w-32">Duration:</span>
                                <span class="text-gray-800">
                                    {{ \Carbon\Carbon::parse($traveller->trip->start_date)->diffInDays($traveller->trip->end_date) + 1 }} days
                                </span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-500 font-medium w-32">Trip Status:</span>
                                @php
                                    $today = date('Y-m-d');
                                    $status = '';
                                    
                                    if ($traveller->trip->status === 'suspended') {
                                        $status = 'Suspended';
                                        $statusClass = 'text-red-500';
                                    } elseif ($traveller->trip->end_date < $today) {
                                        $status = 'Completed';
                                        $statusClass = 'text-gray-500';
                                    } elseif ($traveller->trip->start_date <= $today) {
                                        $status = 'Active';
                                        $statusClass = 'text-green-500';
                                    } else {
                                        $status = 'Upcoming';
                                        $statusClass = 'text-blue-500';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} font-medium">{{ $status }}</span>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Not currently on any trip</p>
                    @endif
                </div>
            </div>

            <!-- Actions Section -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between border-t pt-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Actions</h3>
                    <p class="text-gray-500 text-sm mb-4">Manage this traveller's trip status</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @if($traveller->trip && $traveller->payment_status !== 'cancelled')
                        <form action="{{ route('manager.travellers.cancel-trip', $traveller->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this traveller\'s trip?');">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center">
                                <i class="fas fa-ban mr-2"></i> Cancel Trip
                            </button>
                        </form>
                    @endif
                    
                    @if($traveller->trip)
                        <a href="{{ route('trips.show', $traveller->trip->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
                            <i class="fas fa-eye mr-2"></i> View Trip
                        </a>
                    @else
                        <button disabled class="bg-blue-300 text-white px-4 py-2 rounded cursor-not-allowed opacity-50 flex items-center">
                            <i class="fas fa-eye mr-2"></i> No Trip Assigned
                        </button>
                    @endif
                    
                    <a href="mailto:{{ $traveller->user->email ?? '' }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 flex items-center" {{ !$traveller->user || !$traveller->user->email ? 'disabled' : '' }}>
                        <i class="fas fa-envelope mr-2"></i> Contact
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('transport.layouts.transport')

@section('content')
<div class="mb-8">
    <div class="relative bg-cover bg-center rounded-xl shadow-xl overflow-hidden" style="background-image: url('{{ asset('images/transport-trips.jpg') }}'); height: 300px;">
        <div class="absolute inset-0 bg-gradient-to-r from-transport-blue/90 to-blue-800/90"></div>
        <div class="relative z-10 p-8 h-full flex flex-col justify-end">
            <h1 class="text-4xl font-bold text-white mb-2">My Collaborations</h1>
            <p class="text-blue-100 max-w-2xl">Trips you're providing transportation services for</p>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p class="font-bold">{{ session('success') }}</p>
        </div>
    </div>
@endif

<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
    <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800">
            <i class="fas fa-route text-transport-blue mr-2"></i>
            Your Trips
        </h3>
        
        <a href="{{ route('transport.available-trips') }}" class="bg-transport-orange text-white px-4 py-2 rounded hover:bg-orange-600 transition duration-300 flex items-center">
            <i class="fas fa-search mr-1"></i> Find Available Trips
        </a>
    </div>
    
    @if ($trips && $trips->count() > 0)
        <div class="divide-y divide-gray-100">
            @foreach ($trips as $trip)
                <div class="p-6 hover:bg-gray-50 transition duration-300">
                    <div class="md:flex justify-between items-center">
                        <div class="mb-4 md:mb-0">
                            <h4 class="font-bold text-lg text-gray-800">{{ $trip->destination }}</h4>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($trip->start_date)->format('M d, Y') }}
                                </span>
                                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                    <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($trip->start_date)->diffForHumans() }}
                                </span>
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">
                                    <i class="fas fa-users mr-1"></i> {{ $trip->travellers->count() }} Travellers
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('trips.show', $trip->id) }}" class="bg-transport-blue text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">
                                <i class="fas fa-eye mr-1"></i> Details
                            </a>
                            <form action="{{ route('transport.withdraw-trip', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to stop collaborating with this trip?');">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300">
                                    <i class="fas fa-times-circle mr-1"></i> Uncollaborate
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <i class="fas fa-route text-transport-blue text-2xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-700 mb-2">No trips found</h3>
            <p class="text-gray-500 max-w-md mx-auto">You're not collaborating with any trips yet.</p>
            <a href="{{ route('transport.available-trips') }}" class="mt-4 inline-flex items-center bg-transport-blue text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                <i class="fas fa-search mr-2"></i> Find Available Trips
            </a>
        </div>
    @endif
</div>

<!-- Upcoming Trip Statistics Cards (preserved from original) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="font-semibold text-gray-800">
                <i class="fas fa-calendar-alt text-transport-blue mr-2"></i>
                Upcoming Trips
            </h3>
        </div>
        <div class="p-6">
            <div class="text-4xl font-bold text-transport-blue">{{ $trips ? $trips->where('start_date', '>=', \Carbon\Carbon::now())->count() : 0 }}</div>
            <p class="text-gray-500 mt-1">Scheduled transportations</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="font-semibold text-gray-800">
                <i class="fas fa-users text-transport-green mr-2"></i>
                Total Travellers
            </h3>
        </div>
        <div class="p-6">
            <div class="text-4xl font-bold text-transport-green">
                @php
                    $travellersCount = 0;
                    if ($trips) {
                        foreach ($trips as $trip) {
                            $travellersCount += $trip->travellers->count();
                        }
                    }
                @endphp
                {{ $travellersCount }}
            </div>
            <p class="text-gray-500 mt-1">People transported</p>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="font-semibold text-gray-800">
                <i class="fas fa-map-marked-alt text-transport-orange mr-2"></i>
                Destinations
            </h3>
        </div>
        <div class="p-6">
            <div class="text-4xl font-bold text-transport-orange">
                {{ $trips ? $trips->pluck('destination')->unique()->count() : 0 }}
            </div>
            <p class="text-gray-500 mt-1">Unique locations</p>
        </div>
    </div>
</div>
@endsection

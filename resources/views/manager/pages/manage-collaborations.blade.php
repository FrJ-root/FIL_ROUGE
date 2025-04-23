@extends('manager.layouts.manager')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <a href="{{ route('manager.trips.show', $trip->id) }}" class="text-gray-600 hover:text-gray-900 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Trip
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Manage Trip Collaborators</h1>
        <p class="text-gray-600">{{ $trip->destination }} - {{ date('M d, Y', strtotime($trip->start_date)) }} to {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
    </div>
</div>

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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-blue-500 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="font-bold flex items-center">
                <i class="fas fa-hotel mr-2"></i> Hotels
            </h2>
            <span class="bg-white text-blue-500 px-2 py-1 rounded-full text-xs">
                {{ $trip->hotels->count() }} Assigned
            </span>
        </div>
        
        <div class="p-6">
            <h3 class="font-semibold text-gray-800 mb-3">Current Hotels</h3>
            
            @if($trip->hotels->count() > 0)
                <div class="space-y-3 mb-6">
                    @foreach($trip->hotels as $hotel)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div>
                                <h4 class="font-semibold">{{ $hotel->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $hotel->address }}</p>
                            </div>
                            <form action="{{ route('manager.collaborators.remove', $trip->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="type" value="hotel">
                                <input type="hidden" name="id" value="{{ $hotel->id }}">
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to remove this hotel?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic mb-6">No hotels assigned to this trip yet.</p>
            @endif
            
            <h3 class="font-semibold text-gray-800 mb-3">Add Hotel</h3>
            
            <form action="{{ route('manager.collaborators.add', $trip->id) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="hotel">
                <div class="mb-4">
                    <select name="id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Select a Hotel --</option>
                        @foreach($availableHotels as $hotel)
                            @if(!$trip->hotels->contains($hotel->id))
                                <option value="{{ $hotel->id }}">{{ $hotel->name }} - {{ $hotel->city }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-plus mr-1"></i> Add Hotel
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-green-500 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="font-bold flex items-center">
                <i class="fas fa-user-tie mr-2"></i> Guides
            </h2>
            <span class="bg-white text-green-500 px-2 py-1 rounded-full text-xs">
                {{ $trip->guides->count() }} Assigned
            </span>
        </div>
        
        <div class="p-6">
            <h3 class="font-semibold text-gray-800 mb-3">Current Guides</h3>
            
            @if($trip->guides->count() > 0)
                <div class="space-y-3 mb-6">
                    @foreach($trip->guides as $guide)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div>
                                <h4 class="font-semibold">{{ $guide->user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $guide->specialization }}</p>
                            </div>
                            <form action="{{ route('manager.collaborators.remove', $trip->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="type" value="guide">
                                <input type="hidden" name="id" value="{{ $guide->id }}">
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to remove this guide?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic mb-6">No guides assigned to this trip yet.</p>
            @endif
            
            <h3 class="font-semibold text-gray-800 mb-3">Add Guide</h3>
            
            <form action="{{ route('manager.collaborators.add', $trip->id) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="guide">
                <div class="mb-4">
                    <select name="id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">-- Select a Guide --</option>
                        @foreach($availableGuides as $guide)
                            @if(!$trip->guides->contains($guide->id))
                                <option value="{{ $guide->id }}">{{ $guide->user->name }} - {{ $guide->specialization }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                    <i class="fas fa-plus mr-1"></i> Add Guide
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-amber-500 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="font-bold flex items-center">
                <i class="fas fa-bus mr-2"></i> Transports
            </h2>
            <span class="bg-white text-amber-500 px-2 py-1 rounded-full text-xs">
                {{ $trip->transports->count() }} Assigned
            </span>
        </div>
        
        <div class="p-6">
            <h3 class="font-semibold text-gray-800 mb-3">Current Transports</h3>
            
            @if($trip->transports->count() > 0)
                <div class="space-y-3 mb-6">
                    @foreach($trip->transports as $transport)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div>
                                <h4 class="font-semibold">{{ $transport->company_name }}</h4>
                                <p class="text-sm text-gray-600">{{ $transport->transport_type }}</p>
                            </div>
                            <form action="{{ route('manager.collaborators.remove', $trip->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="type" value="transport">
                                <input type="hidden" name="id" value="{{ $transport->id }}">
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to remove this transport?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic mb-6">No transports assigned to this trip yet.</p>
            @endif
            
            <h3 class="font-semibold text-gray-800 mb-3">Add Transport</h3>
            
            <form action="{{ route('manager.collaborators.add', $trip->id) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="transport">
                <div class="mb-4">
                    <select name="id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="">-- Select a Transport --</option>
                        @foreach($availableTransports as $transport)
                            @if(!$trip->transports->contains($transport->id))
                                <option value="{{ $transport->id }}">{{ $transport->company_name }} - {{ $transport->transport_type }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition-colors">
                    <i class="fas fa-plus mr-1"></i> Add Transport
                </button>
            </form>
        </div>
    </div>
</div>

<div class="mt-8 flex justify-center">
    <a href="{{ route('manager.trips.show', $trip->id) }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Back to Trip Details
    </a>
</div>
@endsection

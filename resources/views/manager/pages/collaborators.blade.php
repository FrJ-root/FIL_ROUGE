@extends('manager.layouts.manager')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-handshake text-manager-primary mr-3"></i>
        Service Providers
    </h1>
    <a href="{{ route('manager.dashboard') }}" class="text-gray-600 hover:text-manager-primary flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
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

<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Find Collaborators</h2>
    <form action="{{ route('manager.collaborators') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-manager-primary focus:border-manager-primary"
                   placeholder="Name or location...">
        </div>
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select id="type" name="type" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-manager-primary focus:border-manager-primary">
                <option value="">All Types</option>
                <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>Hotels</option>
                <option value="guide" {{ request('type') == 'guide' ? 'selected' : '' }}>Guides</option>
                <option value="transport" {{ request('type') == 'transport' ? 'selected' : '' }}>Transportation</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-manager-primary text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex" aria-label="Tabs">
            <button onclick="changeTab('hotels')" id="hotels-tab" 
                    class="tab-btn w-1/3 py-4 px-1 text-center border-b-2 font-medium text-lg tab-active">
                <i class="fas fa-hotel mr-2"></i> Hotels
                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ count($hotels) }}</span>
            </button>
            <button onclick="changeTab('guides')" id="guides-tab" 
                    class="tab-btn w-1/3 py-4 px-1 text-center border-b-2 font-medium text-lg">
                <i class="fas fa-user-tie mr-2"></i> Guides
                <span class="ml-2 bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ count($guides) }}</span>
            </button>
            <button onclick="changeTab('transports')" id="transports-tab" 
                    class="tab-btn w-1/3 py-4 px-1 text-center border-b-2 font-medium text-lg">
                <i class="fas fa-bus mr-2"></i> Transportation
                <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ count($transports) }}</span>
            </button>
        </nav>
    </div>

    <div id="hotels-content" class="tab-content block p-6">
        @if(count($hotels) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($hotels as $hotel)
                    <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="h-40 bg-gray-200 relative">
                            @if($hotel->image)
                                <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-blue-50">
                                    <i class="fas fa-hotel text-blue-300 text-5xl"></i>
                                </div>
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 px-4 py-2 bg-gradient-to-t from-black/70 to-transparent">
                                <h3 class="text-white font-bold">{{ $hotel->name }}</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                <span>{{ $hotel->city }}, {{ $hotel->country }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <i class="fas fa-star text-yellow-400 mr-2"></i>
                                <span>{{ $hotel->star_rating }} Star Rating</span>
                            </div>
                            <div class="flex justify-between mt-4">
                                <a href="mailto:{{ $hotel->user ? $hotel->user->email : '' }}" class="text-manager-primary hover:underline flex items-center">
                                    <i class="fas fa-envelope mr-1"></i> Contact
                                </a>
                                <span class="text-sm px-2 py-1 rounded {{ $hotel->availability == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($hotel->availability ?: 'Unknown') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-hotel text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-500 mb-2">No Hotels Found</h3>
                <p class="text-gray-400">There are no hotels registered in the system yet.</p>
            </div>
        @endif
    </div>

    <div id="guides-content" class="tab-content hidden p-6">
        @if(count($guides) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($guides as $guide)
                    <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="p-6 flex items-center gap-4">
                            <div class="flex-shrink-0">
                                @if($guide->user && $guide->user->picture)
                                    <img src="{{ asset('storage/' . $guide->user->picture) }}" alt="{{ $guide->user ? $guide->user->name : 'Guide' }}" 
                                        class="w-20 h-20 rounded-full object-cover border-2 border-green-500">
                                @else
                                    <div class="w-20 h-20 rounded-full bg-green-50 border-2 border-green-500 flex items-center justify-center">
                                        <i class="fas fa-user-tie text-green-500 text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-800">{{ $guide->user ? $guide->user->name : 'Unknown Guide' }}</h3>
                                @if($guide->specialization)
                                    <p class="text-sm text-gray-600 mb-2">{{ $guide->specialization }}</p>
                                @endif
                                @if($guide->preferred_locations)
                                    <div class="flex items-center text-xs text-gray-500 mb-2">
                                        <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                        <span>{{ \Illuminate\Support\Str::limit($guide->preferred_locations, 30) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between mt-3">
                                    <a href="mailto:{{ $guide->user ? $guide->user->email : '' }}" class="text-manager-primary hover:underline flex items-center text-sm">
                                        <i class="fas fa-envelope mr-1"></i> Contact
                                    </a>
                                    <span class="text-xs px-2 py-1 rounded {{ $guide->availability == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($guide->availability ?: 'Unknown') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-user-tie text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-500 mb-2">No Guides Found</h3>
                <p class="text-gray-400">There are no guides registered in the system yet.</p>
            </div>
        @endif
    </div>

    <div id="transports-content" class="tab-content hidden p-6">
        @if(count($transports) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($transports as $transport)
                    <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-yellow-50 p-4 border-b flex items-center justify-between">
                            <h3 class="font-bold text-gray-800">{{ $transport->company_name }}</h3>
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $transport->transport_type == 'Tourist vehicle' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $transport->transport_type }}
                            </span>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <i class="fas fa-map-marker-alt text-yellow-500 mr-2"></i>
                                <span>{{ $transport->address }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <i class="fas fa-phone text-yellow-500 mr-2"></i>
                                <span>{{ $transport->phone }}</span>
                            </div>
                            <div class="flex justify-between mt-4">
                                <a href="mailto:{{ $transport->user ? $transport->user->email : '' }}" class="text-manager-primary hover:underline flex items-center">
                                    <i class="fas fa-envelope mr-1"></i> Contact
                                </a>
                                <a href="tel:{{ $transport->phone }}" class="text-green-600 hover:underline flex items-center">
                                    <i class="fas fa-phone-alt mr-1"></i> Call
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-bus text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-500 mb-2">No Transport Providers Found</h3>
                <p class="text-gray-400">There are no transport providers registered in the system yet.</p>
            </div>
        @endif
    </div>
</div>

<script>
    function changeTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        document.getElementById(tabName + '-content').classList.remove('hidden');
        
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-manager-primary', 'text-manager-primary', 'tab-active');
            btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
        
        document.getElementById(tabName + '-tab').classList.add('border-manager-primary', 'text-manager-primary', 'tab-active');
        document.getElementById(tabName + '-tab').classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            if (btn.classList.contains('tab-active')) {
                btn.classList.add('border-manager-primary', 'text-manager-primary');
            } else {
                btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            }
        });
    });
</script>

<style>
    .tab-active {
        border-bottom-color: #4F46E5;
        color: #4F46E5;
    }
</style>
@endsection

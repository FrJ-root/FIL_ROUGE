@extends('manager.layouts.manager')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-users text-manager-primary mr-3"></i>
        Travellers
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

<!-- Search & Filter Bar -->
<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <form action="{{ route('manager.travellers') }}" method="GET" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" id="search" placeholder="Name, email or nationality..." 
                   value="{{ request('search') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-manager-primary focus:ring focus:ring-manager-primary focus:ring-opacity-50">
        </div>
        <div class="w-full md:w-48">
            <label for="trip" class="block text-sm font-medium text-gray-700 mb-1">Filter by Trip</label>
            <select name="trip" id="trip" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-manager-primary focus:ring focus:ring-manager-primary focus:ring-opacity-50">
                <option value="">All Trips</option>
                @foreach(App\Models\Trip::orderBy('destination')->get() as $trip)
                    <option value="{{ $trip->id }}" {{ request('trip') == $trip->id ? 'selected' : '' }}>
                        {{ $trip->destination }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-36 flex flex-col justify-end">
            <button type="submit" class="bg-manager-primary text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </div>
    </form>
</div>

<!-- Travellers List -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-manager-primary to-purple-600 px-6 py-4 text-white">
        <h2 class="font-bold text-xl">All Travellers</h2>
    </div>

    @if(isset($travellers) && $travellers->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Traveller
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nationality
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trip
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($travellers as $traveller)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($traveller->user && $traveller->user->picture)
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ asset('storage/' . $traveller->user->picture) }}" 
                                                 alt="{{ $traveller->user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                <span class="text-manager-primary font-medium">
                                                    {{ $traveller->user ? strtoupper(substr($traveller->user->name, 0, 1)) : 'U' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $traveller->user->name ?? 'Unknown User' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $traveller->user->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $traveller->nationality ?? 'Not specified' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($traveller->trip)
                                    <a href="{{ route('manager.trips.show', $traveller->trip->id) }}" class="text-manager-primary hover:underline">
                                        {{ $traveller->trip->destination }}
                                    </a>
                                @else
                                    No trip assigned
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $traveller->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                @if($traveller->trip)
                                <a href="{{ route('manager.trips.show', $traveller->trip->id) }}" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $travellers->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-xl font-bold text-gray-500 mb-2">No Travellers Found</h3>
            <p class="text-gray-400">There are no travellers matching your criteria.</p>
        </div>
    @endif
</div>
@endsection

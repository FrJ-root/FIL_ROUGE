@extends('manager.layouts.manager')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6 text-white flex justify-between items-center">
        <h1 class="text-2xl font-bold">Trip Management</h1>
        <a href="{{ route('manager.trips.create') }}" class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
            <i class="fas fa-plus mr-2"></i> New Trip
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">All Trips</h2>
            <div class="flex items-center space-x-4">
                <form action="{{ route('manager.trips') }}" method="GET" class="flex">
                    <input type="text" name="search" placeholder="Search by destination..." 
                           class="border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                           value="{{ request('search') }}">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded-r-md hover:bg-purple-600">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="relative">
                    <select onchange="window.location.href=this.value" class="appearance-none bg-white border border-gray-300 rounded-md pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="{{ route('manager.trips') }}" {{ !request('filter') ? 'selected' : '' }}>All Trips</option>
                        <option value="{{ route('manager.trips', ['filter' => 'upcoming']) }}" {{ request('filter') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="{{ route('manager.trips', ['filter' => 'past']) }}" {{ request('filter') == 'past' ? 'selected' : '' }}>Past</option>
                        <option value="{{ route('manager.trips', ['filter' => 'my']) }}" {{ request('filter') == 'my' ? 'selected' : '' }}>My Trips</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Destination
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dates
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Travellers
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Collaborators
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($trips as $trip)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($trip->cover_picture)
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ asset('storage/images/trip/' . $trip->cover_picture) }}" 
                                             alt="{{ $trip->destination }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                            <i class="fas fa-mountain text-purple-500"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $trip->destination }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ date('M d, Y', strtotime($trip->start_date)) }}</div>
                            <div class="text-sm text-gray-500">to {{ date('M d, Y', strtotime($trip->end_date)) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $trip->travellers->count() }} travellers</div>
                            <div class="flex -space-x-2 mt-1">
                                @foreach($trip->travellers->take(3) as $traveller)
                                    <div class="h-6 w-6 rounded-full bg-gray-200 border border-white flex items-center justify-center text-xs text-gray-600">
                                        @if($traveller->user && $traveller->user->picture)
                                            <img src="{{ asset('storage/' . $traveller->user->picture) }}" alt="" class="h-full w-full rounded-full object-cover">
                                        @else
                                            {{ substr($traveller->user->name ?? 'U', 0, 1) }}
                                        @endif
                                    </div>
                                @endforeach
                                @if($trip->travellers->count() > 3)
                                    <div class="h-6 w-6 rounded-full bg-gray-100 border border-white flex items-center justify-center text-xs text-gray-600">
                                        +{{ $trip->travellers->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-1">
                                @if($trip->guides->count() > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-user-tie mr-1"></i> {{ $trip->guides->count() }}
                                    </span>
                                @endif
                                
                                @if($trip->hotels->count() > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-hotel mr-1"></i> {{ $trip->hotels->count() }}
                                    </span>
                                @endif
                                
                                @if($trip->transports->count() > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-bus mr-1"></i> {{ $trip->transports->count() }}
                                    </span>
                                @endif

                                @if($trip->guides->count() == 0 && $trip->hotels->count() == 0 && $trip->transports->count() == 0)
                                    <span class="text-gray-400 text-xs">No collaborators</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('trips.show', $trip->id) }}" class="text-indigo-600 hover:text-indigo-900" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('manager.collaborations', $trip->id) }}" class="text-blue-600 hover:text-blue-900" title="Manage Collaborations">
                                    <i class="fas fa-users-cog"></i>
                                </a>
                                <a href="{{ route('trips.edit', $trip->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('manager.trips.destroy', $trip->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this trip?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-route text-gray-300 text-5xl mb-4"></i>
                                <p class="text-lg font-medium">No trips found</p>
                                <p class="text-sm mb-4">Start by creating a new trip</p>
                                <a href="{{ route('manager.trips.create') }}" class="bg-purple-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-600 transition-colors">
                                    <i class="fas fa-plus mr-2"></i> Create Trip
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $trips->links() }}
        </div>
    </div>
</div>
@endsection

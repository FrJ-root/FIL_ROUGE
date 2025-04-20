@extends('manager.layouts.manager')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-route text-manager-primary mr-3"></i>
        Manage Trips
    </h1>
    <a href="{{ route('trips.create') }}" class="bg-manager-primary hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow-md transition-colors flex items-center">
        <i class="fas fa-plus mr-2"></i> Create New Trip
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

<div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
    <div class="p-6">
        @if(count($trips) > 0)
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
                        @foreach($trips as $trip)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($trip->cover_picture)
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                     src="{{ asset('storage/images/trip/' . $trip->cover_picture) }}" 
                                                     alt="{{ $trip->destination }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-500">
                                                    <i class="fas fa-map-marker-alt"></i>
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-1">
                                        @if($trip->hotels->count() > 0)
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                {{ $trip->hotels->count() }} Hotels
                                            </span>
                                        @endif
                                        @if($trip->guides->count() > 0)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                {{ $trip->guides->count() }} Guides
                                            </span>
                                        @endif
                                        @if($trip->transports->count() > 0)
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                {{ $trip->transports->count() }} Transports
                                            </span>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $trips->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-route text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-500 mb-2">No Trips Found</h3>
                <p class="text-gray-400 mb-6">You haven't created any trips yet.</p>
                <a href="{{ route('trips.create') }}" class="bg-manager-primary text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i> Create Your First Trip
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

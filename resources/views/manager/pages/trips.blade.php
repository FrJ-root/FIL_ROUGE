@extends('manager.layouts.manager')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-route text-purple-600 mr-2"></i> Trip Management
        </h1>
        <a href="{{ route('manager.trips.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Create New Trip
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-lg font-semibold text-gray-700">Your Trips</h2>
                    <p class="text-gray-500 text-sm">Manage trips you're responsible for</p>
                </div>
                <div class="relative">
                    <input type="text" id="search" placeholder="Search trips..." 
                           class="px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500 w-full md:w-64">
                    <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travellers</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($trips as $trip)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-sm text-gray-700">{{ $trip->id }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            @if($trip->cover_picture)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/images/trip/' . $trip->cover_picture) }}" alt="{{ $trip->destination }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-purple-200 flex items-center justify-center">
                                                    <i class="fas fa-mountain text-purple-600"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $trip->destination }}</div>
                                            <div class="text-sm text-gray-500">
                                                @if($trip->manager_id == Auth::id())
                                                    <span class="text-purple-600">You are the manager</span>
                                                @else
                                                    <span>{{ $trip->manager ? $trip->manager->name : 'No manager' }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-700">
                                    <div>{{ date('M d, Y', strtotime($trip->start_date)) }}</div>
                                    <div class="text-gray-500">to {{ date('M d, Y', strtotime($trip->end_date)) }}</div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-700">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        {{ $trip->travellers->count() }} travellers
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    @php
                                        $today = date('Y-m-d');
                                        $statusClass = '';
                                        $statusText = '';
                                        
                                        if ($trip->status === 'suspended') {
                                            $statusText = 'Suspended';
                                            $statusClass = 'bg-red-100 text-red-800';
                                        } elseif ($trip->end_date < $today) {
                                            $statusText = 'Completed';
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                        } elseif ($trip->start_date <= $today) {
                                            $statusText = 'Active';
                                            $statusClass = 'bg-green-100 text-green-800';
                                        } else {
                                            $statusText = 'Upcoming';
                                            $statusClass = 'bg-blue-100 text-blue-800';
                                        }
                                    @endphp
                                    <span class="{{ $statusClass }} text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm text-center">
                                    <div class="flex justify-center space-x-3">
                                        <a href="{{ route('trips.show', $trip->id) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('trips.edit', $trip->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit Trip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete Trip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-route text-gray-300 text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">No trips found</p>
                                        <p class="text-sm mt-1">Start by creating your first trip</p>
                                        <a href="{{ route('manager.trips.create') }}" class="mt-4 bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg">
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
</div>

<script>
    // Simple search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const tableRows = document.querySelectorAll('tbody tr');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            tableRows.forEach(row => {
                const destination = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const visible = destination.includes(searchTerm);
                row.style.display = visible ? '' : 'none';
            });
        });
    });
</script>
@endsection

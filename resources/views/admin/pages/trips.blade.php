@extends('admin.layouts.admin-layout')

@section('title', 'Trip Management')

@section('content')
<div class="space-y-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-purple-600 flex items-center">
            <i class="fas fa-plane-departure mr-3 text-purple-500"></i>Trip Management
        </h2>
    </div>
    
    @if (session('success'))
        <div id="statusMsg"
            class="transition-opacity duration-500 bg-{{ session('status_color', 'green') }}-600 text-white px-4 py-2 rounded fixed top-4 right-4 z-50 shadow-lg">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('statusMsg');
                if (msg) {
                    msg.classList.add('opacity-0');
                    setTimeout(() => msg.remove(), 500);
                }
            }, 1500);
        </script>
    @endif

    <div class="bg-gray-800 p-6 rounded-lg mb-6 shadow-lg transform hover:shadow-xl transition-all duration-300 border border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <h3 class="text-white font-semibold mb-4 md:mb-0 flex items-center">
                <i class="fas fa-filter text-purple-400 mr-2"></i>Filter Trips
            </h3>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="search" placeholder="Search trips..." 
                           class="bg-gray-700 text-white rounded-full pl-10 pr-4 py-2 border-0 focus:ring-2 focus:ring-purple-500 w-full md:w-64">
                </div>
                <select id="status-filter" class="bg-gray-700 text-white rounded-full px-4 py-2 border-0 focus:ring-2 focus:ring-purple-500 appearance-none cursor-pointer">
                    <option value="all">All Trips</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="active">Active</option>
                    <option value="suspended">Suspended</option>
                    <option value="past">Past</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <h3 class="text-white font-semibold mb-4 flex items-center">
            <i class="fas fa-list text-purple-400 mr-2"></i>All Trips
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-900 rounded-lg overflow-hidden">
                <thead class="bg-gray-800 border-b border-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Destination</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Duration</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Travellers</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($trips ?? [] as $trip)
                    <tr class="hover:bg-gray-800/50 transition-colors">
                        <td class="px-4 py-3 text-sm text-white">{{ $trip->id }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 rounded-full overflow-hidden bg-gray-700">
                                    @if ($trip->cover_picture)
                                        <img src="{{ asset('storage/images/trip/' . $trip->cover_picture) }}" 
                                             alt="{{ $trip->destination }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-purple-500">
                                            <i class="fas fa-mountain"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-white text-sm font-medium">{{ $trip->destination }}</p>
                                    <p class="text-gray-400 text-xs">{{ date('M d, Y', strtotime($trip->start_date)) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-white">
                            {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days
                        </td>
                        <td class="px-4 py-3 text-sm text-white">
                            <div class="flex items-center">
                                <span class="bg-purple-500/20 text-purple-400 px-2 py-1 rounded-full text-xs">
                                    {{ $trip->travellers->count() }} travellers
                                </span>
                            </div>
                        </td>
                        
                        <td class="px-4 py-3 text-sm text-white">
                            @if($trip->status === 'active')
                                <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs flex items-center w-fit">
                                    <i class="fas fa-check-circle mr-1"></i> Valid
                                </span>
                            @else
                                <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full text-xs flex items-center w-fit">
                                    <i class="fas fa-pause-circle mr-1"></i> Suspended
                                </span>
                            @endif
                            
                            @if($trip->manager_id)
                                <span class="bg-purple-500/20 text-purple-400 px-2 py-1 rounded-full text-xs flex items-center w-fit mt-1">
                                    <i class="fas fa-user-shield mr-1"></i> Assigned to Manager
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-3">
                                <form action="{{ route('admin.trips.status', $trip->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" name="status" value="active" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-full transition-colors" title="Mark Trip as Valid">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.trips.status', $trip->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" name="status" value="suspended" class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-full transition-colors" title="Suspend Trip">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.trips.assign', $trip->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white p-2 rounded-full transition-colors" title="Declare to Manager">
                                        <i class="fas fa-user-shield"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-route text-gray-500 text-5xl mb-4"></i>
                                <p class="text-lg font-medium">No trips found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $trips->links() ?? '' }}
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center hidden">
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full transform transition-all scale-90 opacity-0" id="modalContent">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Confirm Deletion
        </h3>
        <p class="text-gray-300 mb-6">Are you sure you want to delete this trip? This action cannot be undone and will remove all related data including bookings and reservations.</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors">
                Cancel
            </button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors flex items-center">
                    <i class="fas fa-trash mr-2"></i> Delete Permanently
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(tripId) {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('modalContent');
        const form = document.getElementById('deleteForm');
        form.action = `{{ route('admin.trips.destroy', '') }}/${tripId}`;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-90', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('modalContent');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-90', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const statusFilter = document.getElementById('status-filter');
        const rows = document.querySelectorAll('tbody tr');
        
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const status = statusFilter.value;
            
            rows.forEach(row => {
                const destination = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const statusElement = row.querySelector('td:nth-child(5) span');
                const statusText = statusElement ? statusElement.textContent.trim().toLowerCase() : '';
                
                const matchesSearch = destination.includes(searchTerm);
                const matchesStatus = status === 'all' || 
                                     (status === 'upcoming' && statusText === 'upcoming') ||
                                     (status === 'active' && statusText === 'active') ||
                                     (status === 'suspended' && statusText === 'suspended') ||
                                     (status === 'past' && statusText === 'completed');
                
                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }
        
        if (searchInput && statusFilter) {
            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        }
    });
</script>
@endpush

@push('styles')
<style>
    .scale-90 {
        transform: scale(0.9);
    }
    .scale-100 {
        transform: scale(1);
    }
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #1f2937;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #4c1d95;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #6d28d9;
    }
</style>
@endpush
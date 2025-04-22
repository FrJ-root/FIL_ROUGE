@extends('manager.layouts.manager')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        <i class="fas fa-users text-blue-500 mr-2"></i> Travellers Management
    </h1>

    <!-- Payment Status Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Travellers</p>
                <p class="text-2xl font-bold">{{ $totalTravellers }}</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Paid</p>
                <p class="text-2xl font-bold">{{ $paidCount }}</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4 flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-800 mr-4">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Pending Payment</p>
                <p class="text-2xl font-bold">{{ $pendingCount }}</p>
            </div>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center">
                <span class="text-gray-700 font-medium mr-2">Filter:</span>
                <select id="payment-filter" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Travellers</option>
                    <option value="paid" {{ $filter == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ $filter == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                    <option value="cancelled" {{ $filter == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="relative">
                <input type="text" id="search" placeholder="Search travellers..." 
                       class="border border-gray-300 rounded-md pl-10 pr-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
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

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Traveller</th>
                            <th class="py-3 px-6 text-left">Contact</th>
                            <th class="py-3 px-6 text-left">Trip</th>
                            <th class="py-3 px-6 text-left">Nationality</th>
                            <th class="py-3 px-6 text-left">Payment Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($travellers as $traveller)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2">
                                            @if($traveller->user && $traveller->user->picture)
                                                <img class="w-8 h-8 rounded-full object-cover" src="{{ asset('storage/' . $traveller->user->picture) }}" alt="Profile">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                                    {{ $traveller->user ? substr($traveller->user->name, 0, 1) : '?' }}
                                                </div>
                                            @endif
                                        </div>
                                        <span>{{ $traveller->user ? $traveller->user->name : 'Unknown User' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    @if($traveller->user)
                                        <div>{{ $traveller->user->email }}</div>
                                    @else
                                        <span class="text-gray-400">No email available</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-left">
                                    @if($traveller->trip)
                                        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">
                                            {{ $traveller->trip->destination }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">No trip assigned</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $traveller->nationality ?? 'Not specified' }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    @if($traveller->payment_status === 'paid')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Confirmed</span>
                                    @elseif($traveller->payment_status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending Payment</span>
                                    @elseif($traveller->payment_status === 'cancelled')
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">Cancelled</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-xs">Unknown</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('manager.travellers.view', $traveller->id) }}" class="text-blue-500 hover:text-blue-700 mx-1" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($traveller->trip && $traveller->payment_status === 'pending')
                                            <form action="{{ route('manager.travellers.confirm-payment', $traveller->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-500 hover:text-green-700 mx-1" title="Confirm Payment">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($traveller->trip && $traveller->payment_status !== 'cancelled')
                                            <form action="{{ route('manager.travellers.cancel-trip', $traveller->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this traveller\'s trip?');" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-500 hover:text-red-700 mx-1" title="Cancel Trip">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                                        <p class="text-lg font-medium">No travellers found</p>
                                        <p class="text-sm mt-1">There are no travellers registered in the system.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $travellers->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentFilter = document.getElementById('payment-filter');
        const searchInput = document.getElementById('search');
        
        paymentFilter.addEventListener('change', function() {
            window.location.href = "{{ route('manager.travellers') }}?filter=" + this.value;
        });
        
        searchInput.addEventListener('input', function() {
            const rows = document.querySelectorAll('tbody tr');
            const searchTerm = this.value.toLowerCase();
            
            rows.forEach(row => {
                const name = row.querySelector('td:first-child').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const trip = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm) || trip.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection

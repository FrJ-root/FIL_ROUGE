@extends('hotel.layouts.hotel')

@section('content')
<h1 class="text-2xl font-bold mb-6">Bookings</h1>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif

<div class="bg-white shadow rounded-xl overflow-hidden">
    <div class="flex flex-col md:flex-row border-b border-gray-200">
        <button class="booking-tab py-4 px-6 font-medium text-center border-b-2 border-hotel-blue text-hotel-blue flex-1" data-tab="all">
            All Bookings
        </button>
        <button class="booking-tab py-4 px-6 font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 flex-1" data-tab="pending">
            Pending
        </button>
        <button class="booking-tab py-4 px-6 font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 flex-1" data-tab="confirmed">
            Confirmed
        </button>
        <button class="booking-tab py-4 px-6 font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 flex-1" data-tab="cancelled">
            Cancelled
        </button>
    </div>
    
    <div class="p-4 bg-gray-50 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative">
                <input type="text" placeholder="Search bookings..." class="pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-hotel-blue w-full md:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <input type="date" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hotel-blue">
                </div>
                <span class="text-gray-500">to</span>
                <div class="relative">
                    <input type="date" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hotel-blue">
                </div>
                <button class="bg-hotel-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Filter
                </button>
            </div>
        </div>
    </div>
    
    <div id="all-bookings" class="booking-content">
        @if(isset($bookings) && count($bookings) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-500"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->room->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->room->room_type->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ date('M d, Y', strtotime($booking->check_in)) }}</div>
                                    <div class="text-sm text-gray-500">to {{ date('M d, Y', strtotime($booking->check_out)) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${{ number_format($booking->total_price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                          {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' : 
                                             ($booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('hotel.bookings.show', $booking->id) }}" class="text-hotel-blue hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($booking->status == 'pending')
                                        <form method="POST" action="{{ route('hotel.bookings.confirm', $booking->id) }}" class="inline-block mr-2">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-check"></i> Confirm
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('hotel.bookings.cancel', $booking->id) }}" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar-xmark text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-600 mb-2">No Bookings Found</h3>
                <p class="text-gray-500">When you receive bookings, they'll appear here.</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.booking-tab');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => {
                    t.classList.remove('border-hotel-blue', 'text-hotel-blue');
                    t.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-hotel-blue', 'text-hotel-blue');
                const tabName = this.getAttribute('data-tab');
                console.log(`Showing ${tabName} bookings`);
            });
        });
    });
</script>
@endsection

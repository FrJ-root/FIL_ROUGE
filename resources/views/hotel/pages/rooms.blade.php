@extends('hotel.layouts.hotel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Rooms Management</h1>
    <a href="{{ route('hotel.rooms.create') }}" class="bg-hotel-green text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
        <i class="fas fa-plus mr-1"></i> Add New Room
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

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif

<div class="bg-white shadow rounded-xl overflow-hidden">
    <div class="p-4 bg-gray-50 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 mb-2 md:mb-0">Room Inventory</h2>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    <input type="text" placeholder="Search rooms..." class="pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-hotel-blue">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-hotel-blue">
                    <option value="">All Types</option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="suite">Suite</option>
                </select>
            </div>
        </div>
    </div>
    
    @if(isset($rooms) && count($rooms) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price/Night</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($rooms as $room)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-bed text-hotel-blue"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $room->name }}</div>
                                        <div class="text-sm text-gray-500">Room #{{ $room->room_number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $room->room_type ? $room->room_type->name : 'No type assigned' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $room->capacity }} {{ $room->capacity > 1 ? 'persons' : 'person' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${{ number_format($room->price_per_night, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                      {{ $room->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $room->is_available ? 'Available' : 'Booked' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('hotel.rooms.edit', $room->id) }}" class="text-hotel-blue hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('hotel.rooms.destroy', $room->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this room?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $rooms->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-bed text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-bold text-gray-600 mb-2">No Rooms Added Yet</h3>
            <p class="text-gray-500 mb-6">Start adding rooms to your hotel inventory.</p>
            <a href="{{ route('hotel.rooms.create') }}" class="bg-hotel-green text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors">
                <i class="fas fa-plus-circle mr-1"></i> Add Your First Room
            </a>
        </div>
    @endif
</div>
@endsection

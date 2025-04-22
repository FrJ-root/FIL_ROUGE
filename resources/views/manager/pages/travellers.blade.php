@extends('manager.layouts.manager')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        <i class="fas fa-users text-blue-500 mr-2"></i> Travellers Management
    </h1>

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
                            <th class="py-3 px-6 text-left">Status</th>
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
                                        <a href="#" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="w-4 transform hover:text-red-500 hover:scale-110">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
@endsection

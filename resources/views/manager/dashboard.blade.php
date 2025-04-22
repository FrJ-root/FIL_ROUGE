@extends('manager.layouts.manager')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-manager-primary to-purple-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="mt-2 opacity-90">Manage your trips and collaborations with ease</p>
            </div>
            <div class="bg-white/20 p-4 rounded-full">
                <i class="fas fa-briefcase text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Add Travellers Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        <i class="fas fa-users mr-2 text-blue-500"></i> Travellers and Their Trips
    </h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Traveller
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Trip
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dates
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($travellers as $traveller)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($traveller->user && $traveller->user->picture)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $traveller->user->picture) }}" alt="{{ $traveller->user->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ $traveller->user ? strtoupper(substr($traveller->user->name, 0, 1)) : 'U' }}
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $traveller->user ? $traveller->user->name : 'Unknown User' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $traveller->nationality ?? 'No nationality provided' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $traveller->user ? $traveller->user->email : 'No email' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($traveller->trip)
                                <div class="text-sm text-gray-900">{{ $traveller->trip->destination }}</div>
                            @else
                                <div class="text-sm text-gray-500">No trip selected</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($traveller->trip)
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($traveller->trip->start_date)->format('M d, Y') }} - 
                                    {{ \Carbon\Carbon::parse($traveller->trip->end_date)->format('M d, Y') }}
                                </div>
                            @else
                                <div class="text-sm text-gray-500">N/A</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($traveller->payment_status === 'paid')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Confirmed
                                </span>
                            @elseif($traveller->payment_status === 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending Payment
                                </span>
                            @elseif($traveller->payment_status === 'cancelled')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Cancelled
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    No Status
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                
                @if($travellers->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No travellers found
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Stats Cards -->
@endsection

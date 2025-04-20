@extends('manager.layouts.manager')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="{{ $iconClass }} mr-3"></i>
        {{ $pageTitle }}
    </h1>
    <a href="{{ route('manager.trips') }}" class="text-gray-600 hover:text-manager-primary flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> All Trips
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
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Trips with {{ ucfirst($type) }} Collaboration
            </h2>
            
            <div class="flex space-x-2">
                <a href="{{ route('manager.collaborator.trips', 'hotel') }}" class="px-4 py-2 rounded-full text-sm {{ $type == 'hotel' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <i class="fas fa-hotel mr-1"></i> Hotels
                </a>
                <a href="{{ route('manager.collaborator.trips', 'guide') }}" class="px-4 py-2 rounded-full text-sm {{ $type == 'guide' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <i class="fas fa-user-tie mr-1"></i> Guides
                </a>
                <a href="{{ route('manager.collaborator.trips', 'transport') }}" class="px-4 py-2 rounded-full text-sm {{ $type == 'transport' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    <i class="fas fa-bus mr-1"></i> Transports
                </a>
            </div>
        </div>

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
                                {{ ucfirst($type) }}s
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Travellers
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($trips as $trip)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($trip->cover_picture)
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                     src="{{ asset('storage/images/trip/' . $trip->cover_picture) }}" 
                                                     alt="{{ $trip->destination }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-mountain text-gray-400"></i>
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
                                    @if($type == 'hotel')
                                        <div class="text-sm text-gray-900">{{ $trip->hotels->count() }} hotels</div>
                                        @if($trip->hotels->count() > 0)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $trip->hotels->pluck('name')->take(2)->implode(', ') }}
                                                @if($trip->hotels->count() > 2)
                                                    <span>+{{ $trip->hotels->count() - 2 }} more</span>
                                                @endif
                                            </div>
                                        @endif
                                    @elseif($type == 'guide')
                                        <div class="text-sm text-gray-900">{{ $trip->guides->count() }} guides</div>
                                        @if($trip->guides->count() > 0)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $trip->guides->take(2)->map(function($guide) { return $guide->user ? $guide->user->name : 'Unknown'; })->implode(', ') }}
                                                @if($trip->guides->count() > 2)
                                                    <span>+{{ $trip->guides->count() - 2 }} more</span>
                                                @endif
                                            </div>
                                        @endif
                                    @elseif($type == 'transport')
                                        <div class="text-sm text-gray-900">{{ $trip->transports->count() }} transports</div>
                                        @if($trip->transports->count() > 0)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $trip->transports->pluck('company_name')->take(2)->implode(', ') }}
                                                @if($trip->transports->count() > 2)
                                                    <span>+{{ $trip->transports->count() - 2 }} more</span>
                                                @endif
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $trip->travellers->count() }} travellers</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('manager.trips.show', $trip->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('manager.collaborations', $trip->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-users-cog"></i>
                                        </a>
                                        <a href="{{ route('manager.trips.edit', $trip->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $trips->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-route text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-500 mb-2">No Trips Found</h3>
                <p class="text-gray-400">There are no trips with {{ $type }} collaborations.</p>
                <a href="{{ route('manager.trips.create') }}" class="mt-4 inline-block bg-manager-primary text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i> Create New Trip
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

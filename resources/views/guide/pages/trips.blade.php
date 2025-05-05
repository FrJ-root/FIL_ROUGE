@extends('guide.layouts.guide')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-route text-guide-blue mr-3"></i>
        Your Trips
    </h1>
    <a href="{{ route('guide.available-trips') }}" class="bg-guide-green hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 flex items-center">
        <i class="fas fa-plus mr-2"></i> Join New Trip
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

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    @if(isset($trips) && count($trips) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travellers</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($trips as $trip)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-guide-blue"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $trip->destination }}</div>
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
                                @php
                                    $now = new \DateTime();
                                    $startDate = new \DateTime($trip->start_date);
                                    $endDate = new \DateTime($trip->end_date);
                                    
                                    if ($now < $startDate) {
                                        $status = 'Upcoming';
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                    } elseif ($now > $endDate) {
                                        $status = 'Completed';
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                    } else {
                                        $status = 'In Progress';
                                        $statusClass = 'bg-green-100 text-green-800';
                                    }
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('guide.trip.details', $trip->id) }}" class="text-guide-blue hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <form action="{{ route('guide.withdraw-trip', $trip->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to withdraw from this trip?')">
                                        <i class="fas fa-sign-out-alt"></i> Withdraw
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-route text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-bold text-gray-600 mb-2">No Trips Found</h3>
            <p class="text-gray-500 mb-6">You are not currently assigned to any trips.</p>
            <a href="{{ route('guide.available-trips') }}" class="bg-guide-blue text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
                <i class="fas fa-search mr-1"></i> Find Available Trips
            </a>
        </div>
    @endif
</div>
@endsection

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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Trips</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalTrips ?? 0 }}</h3>
                </div>
                <div class="bg-blue-500/10 p-3 rounded-full">
                    <i class="fas fa-globe text-blue-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm">
                <span class="{{ ($tripGrowth ?? 0) >= 0 ? 'text-green-500' : 'text-red-500' }} font-semibold">
                    <i class="fas fa-{{ ($tripGrowth ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                    {{ abs($tripGrowth ?? 0) }}%
                </span>
                <span class="text-gray-500 ml-1">from last month</span>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-2">
            <a href="{{ route('manager.trips') }}" class="text-blue-500 text-sm font-semibold hover:text-blue-700 flex items-center">
                View All Trips <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Active Trips</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $activeTrips ?? 0 }}</h3>
                </div>
                <div class="bg-green-500/10 p-3 rounded-full">
                    <i class="fas fa-hiking text-green-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Currently in progress</span>
                <span class="ml-auto bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    LIVE
                </span>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-2">
            <a href="{{ route('manager.trips', ['filter' => 'active']) }}" class="text-green-500 text-sm font-semibold hover:text-green-700 flex items-center">
                Manage Active <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Upcoming Trips</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $upcomingTrips ?? 0 }}</h3>
                </div>
                <div class="bg-purple-500/10 p-3 rounded-full">
                    <i class="fas fa-calendar-alt text-purple-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm">
                <span class="text-gray-500">Next trip in</span>
                <span class="text-purple-500 font-semibold ml-1">{{ $nextTripDays ?? 'N/A' }} days</span>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-2">
            <a href="{{ route('manager.trips', ['filter' => 'upcoming']) }}" class="text-purple-500 text-sm font-semibold hover:text-purple-700 flex items-center">
                View Schedule <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Travellers</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalTravellers ?? 0 }}</h3>
                </div>
                <div class="bg-orange-500/10 p-3 rounded-full">
                    <i class="fas fa-users text-orange-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm flex justify-between items-center">
                <span class="text-gray-500">Average per trip</span>
                <span class="bg-orange-100 text-orange-800 px-2 py-0.5 rounded text-xs font-semibold">
                    {{ number_format($averageTravellers ?? 0, 1) }}
                </span>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-2">
            <a href="{{ route('manager.travellers') }}" class="text-orange-500 text-sm font-semibold hover:text-orange-700 flex items-center">
                Manage Travellers <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
        <div class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Payment Status</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $paidTravellersCount ?? 0 }}/{{ $totalTravellers ?? 0 }}</h3>
                </div>
                <div class="bg-green-500/10 p-3 rounded-full">
                    <i class="fas fa-money-bill-wave text-green-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $totalTravellers > 0 ? ($paidTravellersCount / $totalTravellers) * 100 : 0 }}%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>{{ $paidTravellersCount ?? 0 }} paid</span>
                    <span>{{ $pendingTravellersCount ?? 0 }} pending</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-2">
            <a href="{{ route('manager.travellers', ['filter' => 'pending']) }}" class="text-orange-500 text-sm font-semibold hover:text-orange-700 flex items-center">
                Review Pending Payments <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h3 class="text-white font-semibold text-lg flex items-center">
                <i class="fas fa-handshake mr-2"></i> Collaboration Statistics
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center border-r border-gray-200">
                    <p class="text-sm text-gray-500">Hotels</p>
                    <h4 class="text-2xl font-bold text-gray-800 mt-1">{{ $hotelCount ?? 0 }}</h4>
                </div>
                <div class="text-center border-r border-gray-200">
                    <p class="text-sm text-gray-500">Guides</p>
                    <h4 class="text-2xl font-bold text-gray-800 mt-1">{{ $guideCount ?? 0 }}</h4>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Transport</p>
                    <h4 class="text-2xl font-bold text-gray-800 mt-1">{{ $transportCount ?? 0 }}</h4>
                </div>
            </div>
            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Collaboration Requests</h4>
                <div class="bg-gray-100 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $collaborationRate ?? 0 }}%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>{{ $pendingRequests ?? 0 }} pending</span>
                    <span>{{ $collaborationRate ?? 0 }}% acceptance rate</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
            <h3 class="text-white font-semibold text-lg flex items-center">
                <i class="fas fa-chart-line mr-2"></i> Revenue Overview
            </h3>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <h4 class="text-2xl font-bold text-gray-800">{{ $currency ?? '$' }}{{ number_format($totalRevenue ?? 0, 2) }}</h4>
                </div>
                <div class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ ($revenueGrowth ?? 0) > 0 ? '+' : '' }}{{ $revenueGrowth ?? 0 }}% vs last month
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Trips</span>
                        <span class="font-medium text-gray-800">{{ $currency ?? '$' }}{{ number_format($tripRevenue ?? 0, 2) }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $tripRevenuePercent ?? 0 }}%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Activities</span>
                        <span class="font-medium text-gray-800">{{ $currency ?? '$' }}{{ number_format($activityRevenue ?? 0, 2) }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $activityRevenuePercent ?? 0 }}%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Commissions</span>
                        <span class="font-medium text-gray-800">{{ $currency ?? '$' }}{{ number_format($commissionRevenue ?? 0, 2) }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $commissionRevenuePercent ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                @if(empty($travellers))
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No travellers found
                        </td>
                    </tr>
                @else
                    @foreach($travellers as $traveller)
                        <tr class="hover:bg-gray-50 transition-colors">
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
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
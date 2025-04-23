@extends('transport.layouts.transport')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-transport-blue to-blue-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h2 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="mt-2 opacity-90">Manage your transport services and view your trips</p>
            </div>
            <div class="bg-white/20 p-4 rounded-full">
                <i class="fas fa-truck text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
    <i class="fas fa-tachometer-alt mr-2 text-transport-blue"></i>
    Quick Actions
</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('transport.profile') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-transport-blue/10 text-transport-blue p-4 rounded-lg mr-4 group-hover:bg-transport-blue group-hover:text-white transition-colors duration-300">
                <i class="fas fa-user-edit text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-transport-blue transition-colors duration-300">View Profile</h3>
                <p class="text-gray-600 text-sm mt-1">Update your company details</p>
            </div>
        </div>
    </a>

    <a href="{{ route('transport.trips') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-transport-green/10 text-transport-green p-4 rounded-lg mr-4 group-hover:bg-transport-green group-hover:text-white transition-colors duration-300">
                <i class="fas fa-route text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-transport-green transition-colors duration-300">Manage Trips</h3>
                <p class="text-gray-600 text-sm mt-1">View and manage assigned trips</p>
            </div>
        </div>
    </a>
    
    <a href="#" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-transport-orange/10 text-transport-orange p-4 rounded-lg mr-4 group-hover:bg-transport-orange group-hover:text-white transition-colors duration-300">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-transport-orange transition-colors duration-300">Availability</h3>
                <p class="text-gray-600 text-sm mt-1">Set your availability schedule</p>
            </div>
        </div>
    </a>

    <a href="{{ route('transport.available-trips') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-transport-orange/10 text-transport-orange p-4 rounded-lg mr-4 group-hover:bg-transport-orange group-hover:text-white transition-colors duration-300">
                <i class="fas fa-search-location text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-transport-orange transition-colors duration-300">Find Trips</h3>
                <p class="text-gray-600 text-sm mt-1">Browse trips needing transport</p>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-transport-blue text-white px-6 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-route mr-2"></i>
                <h3 class="font-bold">Upcoming Trips</h3>
            </div>
            <a href="{{ route('transport.trips') }}" class="text-xs bg-white text-transport-blue px-3 py-1 rounded-full hover:bg-blue-50 transition duration-300">
                View All
            </a>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="border-b border-gray-100 pb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-semibold text-gray-800">Marrakech City Tour</h4>
                            <p class="text-sm text-gray-500">May 25, 2023</p>
                        </div>
                        <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">
                            Upcoming
                        </span>
                    </div>
                </div>
                
                <div class="border-b border-gray-100 pb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-semibold text-gray-800">Sahara Desert Expedition</h4>
                            <p class="text-sm text-gray-500">Jun 10, 2023</p>
                        </div>
                        <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">
                            Upcoming
                        </span>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-semibold text-gray-800">Atlas Mountains Trek</h4>
                            <p class="text-sm text-gray-500">Jul 5, 2023</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-600 text-xs px-3 py-1 rounded-full">
                            Planned
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-transport-green text-white px-6 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-truck mr-2"></i>
                <h3 class="font-bold">Vehicle Status</h3>
            </div>
            <a href="#" class="text-xs bg-white text-transport-green px-3 py-1 rounded-full hover:bg-green-50 transition duration-300">
                Manage
            </a>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-3">
                            <i class="fas fa-bus text-transport-blue"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Tour Bus #1</h4>
                            <p class="text-sm text-gray-500">30 seats</p>
                        </div>
                    </div>
                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">Available</span>
                </div>
                
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-3">
                            <i class="fas fa-shuttle-van text-transport-blue"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Minivan #1</h4>
                            <p class="text-sm text-gray-500">8 seats</p>
                        </div>
                    </div>
                    <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs">Maintenance</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-3">
                            <i class="fas fa-car text-transport-blue"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">SUV #1</h4>
                            <p class="text-sm text-gray-500">5 seats</p>
                        </div>
                    </div>
                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">Booked</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

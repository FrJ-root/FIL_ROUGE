@extends('transport.layouts.transport')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-transport-blue to-blue-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="mt-2 opacity-90">Ready to manage your transport services?</p>
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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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
</div>
@endsection

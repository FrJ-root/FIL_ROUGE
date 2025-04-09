@extends('traveller.layouts.master')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">My Trips</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">
            <!-- Trip filtering options -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-4 mb-4 md:mb-0">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md">All Trips</button>
                        <button class="px-4 py-2 hover:bg-gray-100 rounded-md">Upcoming</button>
                        <button class="px-4 py-2 hover:bg-gray-100 rounded-md">Completed</button>
                        <button class="px-4 py-2 hover:bg-gray-100 rounded-md">Cancelled</button>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder="Search trips..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
            
            @yield('trip_content')
        </div>
    </div>
@endsection

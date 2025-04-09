@extends('traveller.layouts.master')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">My Bookings</h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">
            <!-- Bookings tabs -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <div class="sm:hidden">
                    <label for="booking-tabs" class="sr-only">Select a tab</label>
                    <select id="booking-tabs" name="tabs" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option selected>Hotel Bookings</option>
                        <option>Transportation</option>
                        <option>Tour Guides</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <a href="#" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Hotel Bookings
                            </a>
                            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Transportation
                            </a>
                            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Tour Guides
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            
            @yield('booking_content')
        </div>
    </div>
@endsection

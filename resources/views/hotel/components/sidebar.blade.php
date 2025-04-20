<aside class="w-64 bg-gradient-to-b from-hotel-blue to-blue-800 text-white shadow-xl transform transition-transform duration-300 hover:shadow-2xl">
    <div class="p-6 text-center border-b border-blue-400">
        @if(Auth::user()->picture)
            <img src="{{ asset('storage/' . Auth::user()->picture) }}" 
                 alt="Profile Picture" 
                 class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md hover:scale-105 transition-transform duration-300 object-cover">
        @else
            <div class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md flex items-center justify-center bg-white text-hotel-blue text-3xl font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <h2 class="text-xl font-bold">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-blue-200 mt-1">{{ isset($hotel) && $hotel ? $hotel->name : 'Hotel Manager' }}</p>
        <div class="mt-2 flex justify-center space-x-2">
            <span class="bg-white text-hotel-blue px-2 py-1 rounded-full text-xs font-semibold">Hotel</span>
            <span class="bg-white text-hotel-green px-2 py-1 rounded-full text-xs font-semibold">Verified</span>
        </div>
    </div>
    <nav class="mt-6">
        <a href="{{ route('hotel.dashboard') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('hotel.dashboard') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('hotel.profile') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('hotel.profile*') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-hotel mr-3"></i>
            Hotel Profile
        </a>
        <a href="{{ route('hotel.rooms') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('hotel.rooms*') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-door-open mr-3"></i>
            Rooms
        </a>
        <a href="{{ route('hotel.availability') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('hotel.availability') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-calendar-check mr-3"></i>
            Availability
        </a>
        <a href="{{ route('hotel.trips') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('hotel.trips*') || Route::is('hotel.trip.*') || Route::is('hotel.available-trips') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-suitcase-rolling mr-3"></i>
            Trips
        </a>
        <a href="{{ route('hotel.bookings') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('hotel.bookings*') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-concierge-bell mr-3"></i>
            Bookings
        </a>
        <a href="{{ route('hotel.reviews') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('hotel.reviews') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-star mr-3"></i>
            Reviews
        </a>
    </nav>
    <div class="absolute bottom-0 w-full p-4 border-t border-blue-400">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-300">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>
</aside>

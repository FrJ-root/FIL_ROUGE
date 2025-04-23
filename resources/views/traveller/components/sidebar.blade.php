<aside class="w-64 bg-gradient-to-b from-blue-500 to-indigo-600 text-white shadow-xl transform transition-transform duration-300 hover:shadow-2xl">
    <div class="p-6 text-center border-b border-blue-400">
        @if(Auth::user()->picture)
            <img src="{{ asset('storage/' . Auth::user()->picture) }}" 
                alt="{{ Auth::user()->name }}" 
                class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md hover:scale-105 transition-transform duration-300 object-cover">
        @else
            <div class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md hover:scale-105 transition-transform duration-300 bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white text-3xl font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <h2 class="text-xl font-bold">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-blue-200 mt-1">{{ Auth::user()->traveller && Auth::user()->traveller->nationality ? Auth::user()->traveller->nationality : 'Traveller' }}</p>
        <div class="mt-2 flex justify-center space-x-2">
            <span class="bg-white text-blue-500 px-2 py-1 rounded-full text-xs font-semibold">Traveller</span>
            <span class="bg-white text-green-500 px-2 py-1 rounded-full text-xs font-semibold">Verified</span>
        </div>
    </div>
    <nav class="mt-6">
        <a href="{{ route('traveller.dashboard') }}" class="sidebar-link flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ request()->routeIs('traveller.dashboard') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('traveller.trips') }}" class="sidebar-link flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ request()->routeIs('traveller.trips') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-suitcase mr-3"></i>
            My Trips
        </a>
        <a href="{{ route('traveller.pages.profile') }}" class="sidebar-link flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ request()->routeIs('traveller.pages.profile') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-user-circle mr-3"></i>
            Profile
        </a>
        <a href="{{ route('trips.index') }}" class="sidebar-link flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ request()->routeIs('trips.index') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-map-marked-alt mr-3"></i>
            Explore
        </a>
        <a href="javascript:void(0)" class="sidebar-link flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-heart mr-3"></i>
            Wishlist
        </a>
        <a href="javascript:void(0)" class="sidebar-link flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-cog mr-3"></i>
            Settings
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

<div @click="sidebarOpen = true" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:hidden" 
    x-show="sidebarOpen" 
    x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." 
    x-transition:enter="transition-opacity ease-linear duration-300" 
    x-transition:enter-start="opacity-0" 
    x-transition:enter-end="opacity-100" 
    x-transition:leave="transition-opacity ease-linear duration-300" 
    x-transition:leave-start="opacity-100" 
    x-transition:leave-end="opacity-0" 
    style="display: none;">
    <div @click.away="sidebarOpen = false" class="relative flex w-full max-w-xs flex-1 flex-col bg-gradient-to-b from-blue-500 to-indigo-600 text-white">
        <div class="flex justify-between px-4 pt-5">
            <div class="text-lg font-semibold">Traveller Dashboard</div>
            <button @click="sidebarOpen = false" class="h-6 w-6 text-white">
                <span class="sr-only">Close sidebar</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="mt-5 flex-1 px-2">
            <a href="{{ route('traveller.dashboard') }}" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-white hover:bg-blue-700">
                <i class="fas fa-tachometer-alt mr-4 h-6 w-6"></i>
                Dashboard
            </a>
            <a href="{{ route('traveller.trips') }}" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-white hover:bg-blue-700">
                <i class="fas fa-suitcase mr-4 h-6 w-6"></i>
                My Trips
            </a>
            <a href="{{ route('traveller.pages.profile') }}" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-white hover:bg-blue-700">
                <i class="fas fa-user-circle mr-4 h-6 w-6"></i>
                Profile
            </a>
            <a href="{{ route('trips.index') }}" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-white hover:bg-blue-700">
                <i class="fas fa-map-marked-alt mr-4 h-6 w-6"></i>
                Explore
            </a>
        </div>
    </div>
</div>
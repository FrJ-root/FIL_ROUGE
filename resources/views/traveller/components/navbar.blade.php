<header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <button @click="sidebarOpen = true" class="px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 md:hidden">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center md:ml-0 ml-4">
                <i class="fas fa-globe-americas text-blue-500 mr-2"></i>
                <span>Traveller Dashboard</span>
            </h1>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button class="text-gray-600 hover:text-blue-500 transition-colors">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                </button>
            </div>
            <div class="relative" x-data="{ open: false }">
                @if(Auth::user()->picture)
                    <button @click="open = !open" class="h-10 w-10 rounded-full overflow-hidden border-2 border-blue-500">
                        <img src="{{ asset('storage/' . Auth::user()->picture) }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                    </button>
                @else
                    <button @click="open = !open" class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold border-2 border-blue-500">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </button>
                @endif
                
                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display: none">
                    <a href="{{ route('traveller.pages.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<nav id="navbar" class="fixed top-0 w-full z-50 bg-white p-4 border-b border-red-500 transition-all duration-300">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-12">
            <div class="text-2xl font-bold text-red-500 flex items-center">
                <img src="{{ asset('storage/images/logo/TripyDB.png') }}" alt="TripyDB Logo" class="h-8 md:h-9 lg:h-10 w-auto transform hover:scale-105 transition-transform duration-300">
            </div>

            <div class="hidden md:flex space-x-8">
                <a href="{{ url('/') }}" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1">Home</a>
                <a href="{{ route('destinations.index') }}" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1">Destination</a>
                <a href="{{ route('maps.index') }}" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1">Map</a>
                <a href="{{ route('trips.index') }}" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1">Custom Trip</a>
                <a href="#" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1">
                    <i class="fas fa-mobile-alt mr-1"></i> App
                </a>
                <div x-data="{ open: false, currentCurrency: 'USD' }" class="relative inline-block">
                    <button @click="open = !open" @click.away="open = false" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1 flex items-center">
                        <i class="fas fa-dollar-sign mr-1"></i>
                        <span x-text="currentCurrency"></span>
                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 max-h-96 overflow-y-auto">
                        <a href="#" @click.prevent="currentCurrency = 'MAD'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/ma.png" alt="Morocco" class="w-5 h-auto mr-2">
                            MAD - Moroccan Dirham
                        </a>
                        <a href="#" @click.prevent="currentCurrency = 'USD'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/us.png" alt="USA" class="w-5 h-auto mr-2">
                            USD - US Dollar
                        </a>
                        <a href="#" @click.prevent="currentCurrency = 'EUR'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/eu.png" alt="EU" class="w-5 h-auto mr-2">
                            EUR - Euro
                        </a>
                        <a href="#" @click.prevent="currentCurrency = 'GBP'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/gb.png" alt="UK" class="w-5 h-auto mr-2">
                            GBP - British Pound
                        </a>
                        <a href="#" @click.prevent="currentCurrency = 'JPY'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/jp.png" alt="Japan" class="w-5 h-auto mr-2">
                            JPY - Japanese Yen
                        </a>
                        <a href="#" @click.prevent="currentCurrency = 'CAD'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/ca.png" alt="Canada" class="w-5 h-auto mr-2">
                            CAD - Canadian Dollar
                        </a>
                        <a href="#" @click.prevent="currentCurrency = 'AUD'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/au.png" alt="Australia" class="w-5 h-auto mr-2">
                            AUD - Australian Dollar
                        </a>
                        <a href="#" @click.prevent="currentCurrency = 'CHF'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/ch.png" alt="Switzerland" class="w-5 h-auto mr-2">
                            CHF - Swiss Franc
                        </a>
                        <a href="#" @click.prevent="currentCurrency = 'CNY'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <img src="https://flagcdn.com/w20/cn.png" alt="China" class="w-5 h-auto mr-2">
                            CNY - Chinese Yuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hidden md:flex items-center space-x-4">
            <div class="relative" x-data="{ isSearchFocused: false }">
                <form action="{{ url('/search') }}" method="GET" class="flex items-center">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Explore by destination" 
                        class="pl-10 pr-12 py-3 w-64 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm transition-all duration-300"
                        :class="{ 'ring-2 ring-green-500': isSearchFocused }"
                        @focus="isSearchFocused = true"
                        @blur="isSearchFocused = false"
                        autocomplete="off"
                        required
                    >
                    <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-green-500 transition-colors duration-300 focus:outline-none">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <i class="fas fa-map-marker-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <div x-data="{ open: false, currentLang: '{{ app()->getLocale() ?? 'en' }}' }" class="relative">
                <button @click="open = !open" @click.away="open = false" class="flex items-center text-gray-700 hover:text-green-500">
                    <i class="fas fa-globe mr-1"></i>
                    <span class="text-sm" x-text="currentLang.toUpperCase()"></span>
                    <i class="fas fa-chevron-down text-xs ml-1"></i>
                </button>
                <div x-show="open" class="absolute right-0 mt-2 w-24 bg-white rounded-md shadow-lg py-1 z-50">
                    <a href="{{ url('set-locale/ar') }}" @click="currentLang = 'ar'; open = false" 
                       class="block font-bold px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        AR
                    </a>
                    <a href="{{ url('set-locale/en') }}" @click="currentLang = 'en'; open = false" 
                       class="block font-bold px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        EN
                    </a>
                    <a href="{{ url('set-locale/fr') }}" @click="currentLang = 'fr'; open = false" 
                       class="block font-bold px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        FR
                    </a>
                </div>
            </div>
            
            @guest
                <a href="{{ route('login') }}" class="text-gray-800 font-bold font-medium hover:text-green-500 transition-colors duration-300 px-3 py-2">Log In</a>
                <a href="{{ route('register') }}" class="bg-red-500 font-bold text-white px-5 py-2 rounded-full hover:bg-red-600 transition-colors duration-300 transform hover:scale-105 font-medium shadow-sm">Sign Up</a>
            @else
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center text-gray-800 font-bold hover:text-green-500">
                        <span>{{ Auth::user()->name }}</span>
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('storage/images/default-avatar.png') }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="h-8 w-8 rounded-full object-cover ml-2 border border-gray-200">
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        @php
                            $dashboardRoute = 'traveller.dashboard'; // Default
                            if(Auth::user()->role === 'admin') {
                                $dashboardRoute = 'admin.dashboard';
                            } elseif(Auth::user()->role === 'travel_company') {
                                $dashboardRoute = 'company.dashboard';
                            } elseif(Auth::user()->role === 'hotel') {
                                $dashboardRoute = 'hotel.dashboard';
                            } elseif(Auth::user()->role === 'guide') {
                                $dashboardRoute = 'guide.dashboard';
                            }
                        @endphp
                        <a href="{{ route($dashboardRoute) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="{{ route('user.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ url('/') }}">
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
        
        <button class="md:hidden text-gray-800 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</nav>
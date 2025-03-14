<!-- Navigation Bar -->
<nav id="navbar" class="fixed w-full z-50 bg-white p-4 border-b border-red-500 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo and Navigation Links in one div -->
        <div class="flex items-center space-x-12">
            <!-- Logo -->
            <div class="text-2xl font-bold text-red-500 flex items-center">
                <img src="{{ asset('assets/images/TripyDB.png') }}" alt="TripyDB Logo" class="h-8 md:h-9 lg:h-10 w-auto transform hover:scale-105 transition-transform duration-300">
            </div>
            <!-- Navigation Links -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ url('/') }}" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1">Home</a>
                <a href="#" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1">Travel Guides</a>
                <a href="#" class="text-gray-800 font-bold hover:text-green-500 transition-colors duration-300 border-b-2 border-transparent hover:border-green-500 pb-1">Hotels</a>
            </div>
        </div>
        
        <!-- Search, Language and Auth Buttons all in one div -->
        <div class="hidden md:flex items-center space-x-4">
            <!-- Search Bar - Increased height and width -->
            <div class="relative">
                <input type="text" placeholder="Explore by destination" class="pl-10 pr-4 py-3 w-64 rounded-full border border-gray-300 focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            
            <!-- Language Selector -->
            <div class="relative group">
                <button class="flex items-center text-gray-700 hover:text-green-500">
                    <i class="fas fa-globe mr-1"></i>
                    <span class="text-sm">EN</span>
                    <i class="fas fa-chevron-down text-xs ml-1"></i>
                </button>
                <div class="absolute right-0 mt-2 w-24 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                    <a href="#" class="block font-bold px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">AR</a>
                    <a href="#" class="block font-bold px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">EN</a>
                    <a href="#" class="block font-bold px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">FR</a>
                </div>
            </div>
            
            <!-- Auth Buttons -->
            @guest
                <a href="{{ route('login') }}" class="text-gray-800 font-bold font-medium hover:text-green-500 transition-colors duration-300 px-3 py-2">Log In</a>
                <a href="{{ route('register') }}" class="bg-red-500 font-bold text-white px-5 py-2 rounded-full hover:bg-red-600 transition-colors duration-300 transform hover:scale-105 font-medium shadow-sm">Sign Up</a>
            @else
                <div class="relative group">
                    <button class="flex items-center text-gray-800 font-bold hover:text-green-500">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
        
        <!-- Mobile Menu Button -->
        <button class="md:hidden text-gray-800 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</nav>

<header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-briefcase text-manager-primary mr-2"></i>
            <span>Trip Manager</span>
        </h1>
        <div class="flex items-center space-x-4">
            <a href="{{ route('manager.trips.create') }}" class="bg-manager-primary hover:bg-manager-primary/90 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Create Trip
            </a>
            <div class="relative">
                <button class="text-gray-600 hover:text-manager-primary">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                </button>
            </div>
            <div class="relative group">
                <button class="flex items-center focus:outline-none">
                    @if(Auth::user()->picture)
                        <img src="{{ asset('storage/' . Auth::user()->picture) }}" 
                             alt="Profile" 
                             class="h-8 w-8 rounded-full object-cover border border-gray-200">
                    @else
                        <div class="h-8 w-8 rounded-full bg-manager-primary flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <i class="fas fa-chevron-down text-gray-500 ml-1 text-xs"></i>
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                    <a href="{{ route('manager.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> My Profile
                    </a>
                    <a href="{{ route('manager.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <hr class="my-1">
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

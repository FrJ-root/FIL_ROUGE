<aside class="w-64 bg-gradient-to-b from-manager-primary to-purple-800 text-white shadow-xl transform transition-transform duration-300 hover:shadow-2xl">
    <div class="p-6 text-center border-b border-purple-400">
        @if(Auth::user()->picture)
            <img src="{{ asset('storage/' . Auth::user()->picture) }}" 
                 alt="Profile Picture" 
                 class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md hover:scale-105 transition-transform duration-300 object-cover">
        @else
            <div class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md flex items-center justify-center bg-white text-manager-primary text-3xl font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <h2 class="text-xl font-bold">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-purple-200 mt-1">Trip Manager</p>
        <div class="mt-2 flex justify-center space-x-2">
            <span class="bg-white text-manager-primary px-2 py-1 rounded-full text-xs font-semibold">Manager</span>
            <span class="bg-white text-manager-secondary px-2 py-1 rounded-full text-xs font-semibold">Verified</span>
        </div>
    </div>
    <nav class="mt-6">
        <a href="{{ route('manager.dashboard') }}" class="flex items-center py-3 px-6 hover:bg-purple-700 transition-colors duration-300 {{ Route::is('manager.dashboard') ? 'bg-purple-700' : '' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('manager.trips') }}" class="flex items-center py-3 px-6 hover:bg-purple-700 transition-colors duration-300 {{ Route::is('manager.trips*') ? 'bg-purple-700' : '' }}">
            <i class="fas fa-route mr-3"></i>
            All Trips
        </a>
        
        <!-- Collaborative Trips Section -->
        <div class="px-6 py-3 text-gray-300 text-xs uppercase font-bold">
            Collaborator Trips
        </div>
        
        <a href="{{ route('manager.collaborator.trips', 'hotel') }}" class="flex items-center py-3 px-6 hover:bg-purple-700 transition-colors duration-300">
            <i class="fas fa-hotel mr-3 text-blue-300"></i>
            Hotel Trips
        </a>
        
        <a href="{{ route('manager.collaborator.trips', 'guide') }}" class="flex items-center py-3 px-6 hover:bg-purple-700 transition-colors duration-300">
            <i class="fas fa-user-tie mr-3 text-green-300"></i>
            Guide Trips
        </a>
        
        <a href="{{ route('manager.collaborator.trips', 'transport') }}" class="flex items-center py-3 px-6 hover:bg-purple-700 transition-colors duration-300">
            <i class="fas fa-bus mr-3 text-amber-300"></i>
            Transport Trips
        </a>
        
        <a href="{{ route('manager.collaborators') }}" class="flex items-center py-3 px-6 hover:bg-purple-700 transition-colors duration-300 {{ Route::is('manager.collaborators*') ? 'bg-purple-700' : '' }}">
            <i class="fas fa-users mr-3"></i>
            Collaborators
        </a>
        <a href="{{ route('manager.travellers') }}" class="flex items-center py-3 px-6 hover:bg-purple-700 transition-colors duration-300 {{ Route::is('manager.travellers*') ? 'bg-purple-700' : '' }}">
            <i class="fas fa-hiking mr-3"></i>
            Traveller Trips
        </a>
    </nav>
    <div class="absolute bottom-0 w-full p-4 border-t border-purple-400">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-300">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>
</aside>

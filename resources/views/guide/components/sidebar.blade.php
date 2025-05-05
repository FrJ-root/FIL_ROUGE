<aside class="w-64 bg-gradient-to-b from-guide-blue to-blue-800 text-white shadow-xl transform transition-transform duration-300 hover:shadow-2xl">
    <div class="p-6 text-center border-b border-blue-400">
        @if(Auth::user()->picture)
            <img src="{{ asset('storage/' . Auth::user()->picture) }}" 
                 alt="Profile Picture" 
                 class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md hover:scale-105 transition-transform duration-300 object-cover">
        @else
            <div class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md flex items-center justify-center bg-white text-guide-blue text-3xl font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <h2 class="text-xl font-bold">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-blue-200 mt-1">{{ isset($guide) && $guide ? $guide->specialty ?? 'Travel Guide' : 'Travel Guide' }}</p>
        <div class="mt-2 flex justify-center space-x-2">
            <span class="bg-white text-guide-blue px-2 py-1 rounded-full text-xs font-semibold">Guide</span>
            <span class="bg-white text-guide-green px-2 py-1 rounded-full text-xs font-semibold">Verified</span>
        </div>
    </div>
    <nav class="mt-6">
        <a href="{{ route('guide.dashboard') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('guide.dashboard') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('guide.profile') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('guide.profile*') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-user mr-3"></i>
            Guide Profile
        </a>
        <a href="{{ route('guide.trips') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('guide.trips*') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-route mr-3"></i>
            Trips
        </a>
        <a href="{{ route('guide.availability') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('guide.availability') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-calendar-check mr-3"></i>
            Availability
        </a>
        <a href="{{ route('guide.travellers') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('guide.travellers*') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-users mr-3"></i>
            Travellers
        </a>
        <a href="{{ route('guide.reviews') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('guide.reviews') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-star mr-3"></i>
            Reviews
        </a>
        <a href="{{ route('guide.messages') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300 {{ Route::is('guide.messages') ? 'bg-blue-700' : '' }}">
            <i class="fas fa-comments mr-3"></i>
            Messages
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

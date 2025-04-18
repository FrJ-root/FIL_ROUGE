<aside class="w-64 bg-gradient-to-b from-adventure-blue to-blue-800 text-white shadow-xl transform transition-transform duration-300 hover:shadow-2xl">
    <div class="p-6 text-center border-b border-blue-400">
        <img src="{{ Auth::user()->picture ? asset('storage/' . Auth::user()->picture) : asset('images/default-profile.png') }}" 
             alt="Profile Picture" 
             class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md hover:scale-105 transition-transform duration-300">
        <h2 class="text-xl font-bold">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-blue-200 mt-1">{{ Auth::user()->guide->specialization ?? 'Professional Guide' }}</p>
        <div class="mt-2 flex justify-center space-x-2">
            <span class="bg-white text-adventure-blue px-2 py-1 rounded-full text-xs font-semibold">Licensed</span>
            <span class="bg-white text-adventure-green px-2 py-1 rounded-full text-xs font-semibold">Verified</span>
        </div>
    </div>
    <nav class="mt-6">
        <a href="{{ route('guide.dashboard') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('guide.profile') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-user-circle mr-3"></i>
            Profile
        </a>
        <a href="{{ route('guide.availability') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-calendar-check mr-3"></i>
            Availability
        </a>
        <a href="{{ route('guide.travellers') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-users mr-3"></i>
            Travellers
        </a>
        <a href="{{ route('guide.reviews') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
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

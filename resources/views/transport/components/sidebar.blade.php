<aside class="w-64 bg-gradient-to-b from-transport-blue to-blue-800 text-white shadow-xl transform transition-transform duration-300 hover:shadow-2xl">
    <div class="p-6 text-center border-b border-blue-400">
        <img src="{{ Auth::user()->picture ? asset('storage/' . Auth::user()->picture) : asset('images/default-profile.png') }}" 
             alt="Profile Picture" 
             class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md hover:scale-105 transition-transform duration-300">
        <h2 class="text-xl font-bold">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-blue-200 mt-1">{{ Auth::user()->transportCompany->company_name ?? 'Transport Company' }}</p>
    </div>
    <nav class="mt-6">
        <a href="{{ route('transport.dashboard') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('transport.profile') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-user-circle mr-3"></i>
            Profile
        </a>
        <a href="{{ route('transport.trips') }}" class="flex items-center py-3 px-6 hover:bg-blue-700 transition-colors duration-300">
            <i class="fas fa-route mr-3"></i>
            Trips
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

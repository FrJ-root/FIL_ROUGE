<div class="ml-3 relative" x-data="{ open: false }">
    <div>
        <button @click="open = !open" class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
            <span class="sr-only">Open user menu</span>
            @if(Auth::user()->picture)
                <img class="h-8 w-8 rounded-full object-cover border-2 border-white shadow" 
                     src="{{ asset('storage/' . Auth::user()->picture) }}" 
                     alt="{{ Auth::user()->name }}">
            @else
                <img class="h-8 w-8 rounded-full object-cover border-2 border-white shadow" 
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=128&background=3b82f6&color=ffffff" 
                     alt="{{ Auth::user()->name }}">
            @endif
        </button>
    </div>
    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <a href="{{ route('traveller.pages.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</button>
        </form>
    </div>
</div>

@php
    $textSize = $isMobile ? 'text-base' : 'text-sm';
    $iconMargin = $isMobile ? 'mr-4' : 'mr-3';
    $route = request()->route()->getName();
@endphp

<a href="{{ route('traveller.dashboard') }}" class="group flex items-center px-2 py-2 {{ $textSize }} font-medium {{ $route == 'traveller.dashboard' ? 'text-gray-900 bg-gray-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-md">
    <svg class="{{ $iconMargin }} h-6 w-6 {{ $route == 'traveller.dashboard' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
    </svg>
    Dashboard
</a>

<a href="{{ route('traveller.trips') }}" class="group flex items-center px-2 py-2 {{ $textSize }} font-medium {{ $route == 'traveller.trips' ? 'text-gray-900 bg-gray-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-md {{ $isMobile ? 'mt-1' : '' }}">
    <svg class="{{ $iconMargin }} h-6 w-6 {{ $route == 'traveller.trips' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
    </svg>
    My Trips
</a>

<a href="{{ route('traveller.pages.profile') }}" class="group flex items-center px-2 py-2 {{ $textSize }} font-medium {{ $route == 'traveller.profile' ? 'text-gray-900 bg-gray-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} rounded-md {{ $isMobile ? 'mt-1' : '' }}">
    <svg class="{{ $iconMargin }} h-6 w-6 {{ $route == 'traveller.profile' ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
    </svg>
    Profile
</a>

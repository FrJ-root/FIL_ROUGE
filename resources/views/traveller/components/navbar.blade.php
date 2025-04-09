<!-- Top navbar -->
<div class="relative z-10 flex h-16 flex-shrink-0 bg-white shadow">
    <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 md:hidden">
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    <div class="flex flex-1 justify-between px-4 sm:px-6">
        <div class="flex flex-1">
            <div class="mt-1 relative rounded-md shadow-sm">
                <!-- Search bar if needed -->
            </div>
        </div>
        <div class="ml-4 flex items-center md:ml-6">
            <!-- Include profile dropdown component -->
            @include('traveller.components.profile-dropdown')
        </div>
    </div>
</div>

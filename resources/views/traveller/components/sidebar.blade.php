<div @click="sidebarOpen = true" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:hidden" 
    x-show="sidebarOpen" 
    x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." 
    x-transition:enter="transition-opacity ease-linear duration-300" 
    x-transition:enter-start="opacity-0" 
    x-transition:enter-end="opacity-100" 
    x-transition:leave="transition-opacity ease-linear duration-300" 
    x-transition:leave-start="opacity-100" 
    x-transition:leave-end="opacity-0" 
    style="display: none;">
    <div @click.away="sidebarOpen = false" class="relative flex w-full max-w-xs flex-1 flex-col bg-white pb-4 pt-5">
        <div class="flex justify-between px-4">
            <div class="text-lg font-semibold text-blue-600">Traveller Dashboard</div>
            <button @click="sidebarOpen = false" class="h-6 w-6 text-gray-500">
                <span class="sr-only">Close sidebar</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="mt-5 flex-1 px-2">
            @include('traveller.components.sidebar-links', ['isMobile' => true])
        </nav>
    </div>
</div>

<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white border-r sidebar-scroll">
            <div class="flex items-center flex-shrink-0 px-4">
                <span class="text-xl font-semibold text-blue-600">Traveller Dashboard</span>
            </div>
            <div class="flex flex-col flex-grow mt-5">
                <nav class="flex-1 px-2 bg-white space-y-1">
                    @include('traveller.components.sidebar-links', ['isMobile' => false])
                </nav>
            </div>
        </div>
    </div>
</div>
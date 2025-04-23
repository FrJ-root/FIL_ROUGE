<div x-data="{ open: false, isCollapsed: true }" @sidebar-state-changed.window="$event.detail.isCollapsed ? isCollapsed = true : isCollapsed = false" class="sidebar-wrapper">
    <button @click="open = !open" class="fixed z-40 bottom-4 right-4 bg-red-500 text-white rounded-full p-3 shadow-lg md:hidden">
        <i class="fas" :class="open ? 'fa-times' : 'fa-bars'"></i>
    </button>

    <button 
        @click="isCollapsed = !isCollapsed; $dispatch('sidebar-state-changed', { isCollapsed: isCollapsed })" 
        class="fixed z-40 top-1/2 transform -translate-y-1/2 bg-white text-red-500 rounded-full p-2 shadow-md border border-gray-200 hidden md:flex items-center justify-center hover:bg-gray-50 transition-all duration-300"
        :class="{'right-auto left-[4.1rem]': isCollapsed, 'right-auto left-[16.1rem]': !isCollapsed}"
    >
        <i class="fas" :class="isCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
    </button>

    <aside 
        class="fixed top-0 left-0 z-30 h-screen pt-16 bg-white border-r border-gray-200 shadow-lg transition-all duration-300 transform overflow-y-auto"
        :class="{
            'translate-x-0 w-64': open && !isCollapsed,
            '-translate-x-full w-64': !open && !isCollapsed,
            'translate-x-0 w-16': open && isCollapsed,
            '-translate-x-full w-16': !open && isCollapsed,
            'md:translate-x-0': true
        }"
    >
        <div class="h-full px-3 py-4 pt-4 hide-scrollbar">
            
            <ul class="space-y-3 mt-2">
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                        <i class="fas fa-hotel w-6 text-red-500"></i>
                        <span class="ml-3 whitespace-nowrap" x-show="!isCollapsed">Hotels & Homes</span>
                        <span class="tooltip absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="isCollapsed">Hotels & Homes</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                        <i class="fas fa-plane w-6 text-red-500"></i>
                        <span class="ml-3 whitespace-nowrap" x-show="!isCollapsed">Flights</span>
                        <span class="tooltip absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="isCollapsed">Flights</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                        <i class="fas fa-train w-6 text-red-500"></i>
                        <span class="ml-3 whitespace-nowrap" x-show="!isCollapsed">Trains</span>
                        <span class="tooltip absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="isCollapsed">Trains</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                        <i class="fas fa-car w-6 text-red-500"></i>
                        <span class="ml-3 whitespace-nowrap" x-show="!isCollapsed">Cars</span>
                        <span class="tooltip absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="isCollapsed">Cars</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                        <i class="fas fa-monument w-6 text-red-500"></i>
                        <span class="ml-3 whitespace-nowrap" x-show="!isCollapsed">Attractions & Tours</span>
                        <span class="tooltip absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="isCollapsed">Attractions & Tours</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                        <i class="fas fa-plane-departure w-6 text-red-500"></i>
                        <span class="ml-3 whitespace-nowrap" x-show="!isCollapsed">Flight + Hotel</span>
                        <span class="tooltip absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="isCollapsed">Flight + Hotel</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                    </a>
                </li>
                <li>
                    <a href="{{ route('maps.index') }}" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                    </a>
                </li>
                <li>
                    <a href="{{ route('trips.index') }}" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                    </a>
                </li>
                <li>
                    <a href="{{ route('destinations.index') }}" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 group relative">
                    </a>
                </li>
            </ul>
            <div class="pt-6 mt-6 border-t border-gray-200" x-show="!isCollapsed">
                <a href="#" class="flex items-center p-2 text-red-500 rounded-lg hover:bg-gray-100 group">
                    <i class="fas fa-question-circle w-6"></i>
                    <span class="ml-3">Help Center</span>
                </a>
            </div>
            <div class="pt-6 mt-6 border-t border-gray-200 text-center" x-show="isCollapsed">
                <a href="#" class="flex justify-center p-2 text-red-500 rounded-lg hover:bg-gray-100 group relative">
                    <i class="fas fa-question-circle"></i>
                    <span class="tooltip absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300">Help Center</span>
                </a>
            </div>
        </div>
    </aside>

    <div 
        x-show="open" 
        @click="open = false" 
        class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>
</div>

<style>
    @media (min-width: 768px) {
        .main-content {
            margin-left: 4rem;
            transition: margin-left 0.3s ease;
        }
        
        .main-content.sidebar-collapsed {
            margin-left: 4rem;
        }
    }
    
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .tooltip {
        z-index: 50;
        pointer-events: none;
        white-space: nowrap;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    aside {
        max-height: 100vh;
    }
    
    .map-container {
        position: relative;
        width: 100%;
        height: 100%;
    }
    
    .map {
        width: 100%;
        height: 100%;
    }
    
    .map-controls {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 100;
        background: rgba(255, 255, 255, 0.9);
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
</style>
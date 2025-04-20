<header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-hotel text-hotel-blue mr-2"></i>
            <span>Hotel Management</span>
        </h1>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <button class="text-gray-600 hover:text-hotel-blue">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                </button>
            </div>
            <div class="h-8 w-8 rounded-full bg-hotel-blue flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </div>
</header>

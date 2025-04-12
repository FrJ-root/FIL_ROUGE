<footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white pt-16 pb-6 relative">
    <!-- Wave Shape Divider -->
    <div class="absolute top-0 left-0 right-0 transform -translate-y-full overflow-hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="fill-current text-gray-900">
            <path d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,85.3C672,75,768,85,864,96C960,107,1056,117,1152,112C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Logo & About -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <img src="{{ asset('storage/images/logo/TripyDB.png') }}" alt="TripyDB Logo" class="h-12 w-auto mr-3">
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">Explore the world with TripyDB - your ultimate travel companion. We help you discover amazing destinations, plan unforgettable trips, and create lifelong memories.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors transform hover:scale-110 duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors transform hover:scale-110 duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors transform hover:scale-110 duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors transform hover:scale-110 duration-300">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>

            <!-- Explore -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-white relative border-b border-gray-700 pb-2">
                    <span class="relative z-10">Explore</span>
                    <span class="absolute left-0 bottom-0 w-12 h-0.5 bg-red-500"></span>
                </h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> Home
                    </a></li>
                    <li><a href="{{ route('destinations.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> Destinations
                    </a></li>
                    <li><a href="{{ route('trips.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> Trips
                    </a></li>
                    <li><a href="{{ route('maps.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> Interactive Map
                    </a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> About Us
                    </a></li>
                </ul>
            </div>

            <!-- Travel Resources -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-white relative border-b border-gray-700 pb-2">
                    <span class="relative z-10">Travel Resources</span>
                    <span class="absolute left-0 bottom-0 w-12 h-0.5 bg-red-500"></span>
                </h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> Travel Guides
                    </a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> City Itineraries
                    </a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> Travel Tips
                    </a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> FAQ
                    </a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-chevron-right text-xs mr-2 text-red-400"></i> Contact Us
                    </a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-white relative border-b border-gray-700 pb-2">
                    <span class="relative z-10">Get Travel Inspiration</span>
                    <span class="absolute left-0 bottom-0 w-12 h-0.5 bg-red-500"></span>
                </h3>
                <p class="text-gray-400 text-sm mb-4">Subscribe to our newsletter for the latest travel deals, tips and inspiration.</p>
                <form class="flex flex-col space-y-2">
                    <div class="relative">
                        <input 
                            type="email" 
                            placeholder="Your email address" 
                            class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        >
                        <button type="submit" class="absolute right-1 top-1 bg-red-500 text-white p-1 rounded-md hover:bg-red-600 transition-colors">
                            <i class="fas fa-paper-plane px-2"></i>
                        </button>
                    </div>
                </form>
                <div class="mt-4">
                    <p class="text-gray-500 text-xs">By subscribing, you agree to our Privacy Policy and consent to receive updates.</p>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <div class="mb-4 md:mb-0">
                <p>&copy; {{ date('Y') }} TripyDB. All rights reserved.</p>
            </div>
            
            <div class="flex flex-wrap justify-center space-x-4">
                <a href="#" class="hover:text-white transition-colors mb-2 md:mb-0">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors mb-2 md:mb-0">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors mb-2 md:mb-0">Cookie Policy</a>
            </div>
        </div>
    </div>

    <!-- Badge/App Download Section -->
    <div class="mt-8 py-6 bg-gray-950/50 backdrop-blur-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <div class="flex items-center">
                    <i class="fas fa-mobile-alt text-red-500 text-3xl mr-4"></i>
                    <div>
                        <h4 class="text-white font-bold">Download Our App</h4>
                        <p class="text-gray-400 text-sm">Plan trips on the go with our mobile app</p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="transform hover:scale-105 transition-transform">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store" class="h-10">
                    </a>
                    <a href="#" class="transform hover:scale-105 transition-transform">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="h-10">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

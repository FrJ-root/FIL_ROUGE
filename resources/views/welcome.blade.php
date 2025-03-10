<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TravelEase - Your Journey Begins Here</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <!-- Additional Styles -->
        <style>
            .floating {
                animation: floating 3s ease-in-out infinite;
            }
            
            @keyframes floating {
                0% { transform: translate(0, 0px); }
                50% { transform: translate(0, 15px); }
                100% { transform: translate(0, -0px); }
            }

            .slide-in {
                animation: slideIn 1s ease-out forwards;
            }

            @keyframes slideIn {
                from { transform: translateX(-100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }

            .fade-up {
                animation: fadeUp 0.8s ease-out forwards;
            }

            @keyframes fadeUp {
                from { transform: translateY(20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            .bg-travel-pattern {
                background-image: url('path/to/pattern.png');
                background-repeat: repeat;
                animation: bgScroll 20s linear infinite;
            }

            @keyframes bgScroll {
                from { background-position: 0 0; }
                to { background-position: 100% 100%; }
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-indigo-900 min-h-screen">
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <!-- Animated Background Pattern -->
            <div class="absolute inset-0 bg-travel-pattern opacity-10"></div>

            <!-- Navigation -->
            <nav class="relative z-10 p-6">
                <div class="container mx-auto flex justify-between items-center">
                    <!-- Logo -->
                    <div class="slide-in">
                        <h1 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                            Travel<span class="text-orange-500">Ease</span>
                        </h1>
                    </div>

                    <!-- Navigation Links -->
                    @if (Route::has('login'))
                        <div class="fade-up space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-4 py-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 transition">
                                    Login
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </nav>

            <!-- Hero Content -->
            <div class="container mx-auto px-6 py-20">
                <div class="flex flex-col lg:flex-row items-center justify-between">
                    <!-- Left Content -->
                    <div class="lg:w-1/2 fade-up">
                        <h2 class="text-5xl font-bold text-gray-800 dark:text-white mb-8">
                            Discover Your Next Adventure
                        </h2>
                        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                            Plan, explore, and experience the world with TravelEase. 
                            Your perfect journey starts here.
                        </p>
                        <a href="#get-started" 
                           class="px-8 py-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition transform hover:scale-105">
                            Start Planning
                        </a>
                    </div>

                    <!-- Right Content - Floating Illustration -->
                    <div class="lg:w-1/2 mt-10 lg:mt-0">
                        <div class="floating">
                            <!-- Replace with your travel-themed illustration -->
                            <img src="/images/travel-illustration.svg" 
                                 alt="Travel Illustration" 
                                 class="w-full max-w-xl mx-auto">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="bg-white dark:bg-gray-800 py-20">
                <div class="container mx-auto px-6">
                    <h3 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-16">
                        Why Choose TravelEase?
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        <!-- Feature Cards with Animations -->
                        @foreach([
                            ['icon' => '✈️', 'title' => 'Smart Planning', 'description' => 'Intelligent travel itineraries customized for you'],
                            ['icon' => '🌎', 'title' => 'Global Coverage', 'description' => 'Access destinations worldwide with local insights'],
                            ['icon' => '💰', 'title' => 'Best Deals', 'description' => 'Find the most competitive prices for your journey']
                        ] as $feature)
                            <div class="fade-up p-6 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-lg transition">
                                <div class="text-4xl mb-4">{{ $feature['icon'] }}</div>
                                <h4 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">
                                    {{ $feature['title'] }}
                                </h4>
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ $feature['description'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Add your JavaScript -->
        <script>
            // Add intersection observer for scroll animations
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-up');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-up').forEach(element => {
                observer.observe(element);
            });
        </script>
    </body>
</html>
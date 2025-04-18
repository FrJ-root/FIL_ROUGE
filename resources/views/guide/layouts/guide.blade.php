<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'adventure-blue': '#1E88E5',
                        'adventure-green': '#00C853',
                        'adventure-orange': '#FF6D00',
                        'adventure-sand': '#F5F5DC',
                    },
                    fontFamily: {
                        'sans': ['"Open Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-adventure-sand font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('guide.components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <header class="bg-white shadow-md">
                <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-compass text-adventure-blue mr-2"></i>
                        <span>Guide Dashboard</span>
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-600 hover:text-adventure-blue">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-adventure-blue flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Simple animation for sidebar items
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('mouseenter', () => {
                link.querySelector('i').classList.add('animate-pulse');
            });
            link.addEventListener('mouseleave', () => {
                link.querySelector('i').classList.remove('animate-pulse');
            });
        });
    </script>
</body>
</html>
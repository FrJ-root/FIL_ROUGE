<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hotel-blue': '#1976D2',
                        'hotel-green': '#26A69A',
                        'hotel-orange': '#FF9800',
                        'hotel-red': '#EF5350',
                    },
                    fontFamily: {
                        'sans': ['"Poppins"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('hotel.components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            @include('hotel.components.header')

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

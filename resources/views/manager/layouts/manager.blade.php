<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Manager Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'manager-primary': '#4F46E5',
                        'manager-secondary': '#10B981',
                        'manager-accent': '#F59E0B',
                        'manager-dark': '#111827',
                        'manager-light': '#F9FAFB',
                    },
                    fontFamily: {
                        'sans': ['"Inter"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        @include('manager.components.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('manager.components.navbar')

            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('nav a').forEach(link => {
                link.addEventListener('mouseenter', () => {
                    link.querySelector('i').classList.add('animate-pulse');
                });
                link.addEventListener('mouseleave', () => {
                    link.querySelector('i').classList.remove('animate-pulse');
                });
            });
        });
    </script>
</body>
</html>

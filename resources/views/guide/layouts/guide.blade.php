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
                        'guide-blue': '#2563EB',
                        'guide-green': '#10B981',
                        'guide-orange': '#F59E0B',
                        'guide-red': '#EF4444',
                        'guide-purple': '#8B5CF6',
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
    <style>
        .peer:checked ~ .peer-checked\:bg-guide-blue {
            background-color: #2563EB;
        }
        
        .peer:checked ~ .peer-checked\:border-guide-blue {
            border-color: #2563EB;
        }
        
        .hover\:bg-guide-blue:hover {
            background-color: #2563EB;
        }
        
        .bg-guide-blue {
            background-color: #2563EB;
        }
        
        .text-guide-blue {
            color: #2563EB;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        @include('guide.components.sidebar')
        <div class="flex-1 flex flex-col overflow-hidden">
            @include('guide.components.header')
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('mouseenter', () => {
                link.querySelector('i').classList.add('animate-pulse');
            });
            link.addEventListener('mouseleave', () => {
                link.querySelector('i').classList.remove('animate-pulse');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
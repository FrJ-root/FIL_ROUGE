<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Travel Planner' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            background-color: white;
            color: #333;
        }
        .hover-scale {
            transform: scale(1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(255, 59, 59, 0.2);
        }
        .gradient-overlay {
            background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.7));
        }
        .destination-card:hover .destination-info {
            opacity: 1;
            transform: translateY(0);
        }
        .destination-info {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }
        .navbar-fixed {
            background-color: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-white text-gray-800">
    @include('components.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 100) {
                    navbar.classList.add('navbar-fixed');
                } else {
                    navbar.classList.remove('navbar-fixed');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Traveller Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap">  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-travel-pattern {
            background-image: url('{{ asset('images/travel-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .bg-overlay {
            background-color: rgba(249, 250, 251, 0.9);
        }
        
        .sidebar-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'adventure-blue': '#1E88E5',
                        'adventure-green': '#00C853',
                        'adventure-orange': '#FF6D00',
                        'adventure-purple': '#7E57C2',
                    },
                    fontFamily: {
                        'sans': ['"Open Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    @php
        // Check if user has pending payments
        $pendingPayment = false;
        if (Auth::check() && Auth::user()->role === 'traveller') {
            $traveller = Auth::user()->traveller;
            if ($traveller && $traveller->trip_id && $traveller->payment_status === 'pending') {
                $pendingPayment = true;
            }
        }
    @endphp
    
    @if($pendingPayment)
    <div class="bg-yellow-500 text-white text-center py-2 px-4">
        You have an unpaid trip booking. 
        <a href="{{ route('traveller.trips.payment', Auth::user()->traveller->trip_id) }}" class="font-bold underline">Complete payment now</a>
        to confirm your booking.
    </div>
    @endif
    
    <div class="min-h-screen">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen">
            @include('traveller.components.sidebar')

            <div class="flex flex-col flex-1 w-0 overflow-hidden">
                @include('traveller.components.navbar')

                <main class="flex-1 relative overflow-y-auto focus:outline-none">
                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
    
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script>
        // Simple animation for sidebar items
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
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
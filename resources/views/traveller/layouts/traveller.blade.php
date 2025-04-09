@extends('traveller.layouts.master')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Traveller Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/traveller-dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
            @include('traveller.components.sidebar')
            <div class="flex flex-col flex-1 w-0 overflow-hidden">
                @include('traveller.components.navbar')
                <main class="flex-1 relative overflow-y-auto focus:outline-none">
                    <div class="py-6">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
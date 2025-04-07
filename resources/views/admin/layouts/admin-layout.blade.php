<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Youdemy - Admin Dashboard">
    <title>Youdemy - @yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes pulse {
            0%,
            100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
        .hex-pattern {
            background: linear-gradient(120deg, #000 0%, transparent 50%),
                linear-gradient(240deg, #000 0%, transparent 50%),
                linear-gradient(360deg, #000 0%, transparent 50%);
            background-size: 10px 10px;
        }
        .typing::after {
            content: '|';
            animation: blink 1s step-end infinite;
        }
        @keyframes blink {
            from,
            to {
                opacity: 1
            }
            50% {
                opacity: 0
            }
        }
        .status-pulse {
            animation: statusPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes statusPulse {
            0%,
            100% {
                background-color: rgba(52, 211, 153, 0.2);
            }
            50% {
                background-color: rgba(52, 211, 153, 0.4);
            }
        }
        body {
            font-family: 'Courier New', monospace;
        }
        #logoutPopup {
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            font-family: 'Courier New', monospace;
        }
        .logout-popup-inner {
            background-color: rgba(0, 0, 0, 0.85);
            color: #00FF00;
            border: 2px solid #00FF00;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            width: 300px;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            position: relative;
        }
        .logout-popup-inner h2 {
            font-size: 1.5rem;
            letter-spacing: 2px;
            color: #00FF00;
            text-transform: uppercase;
            text-shadow: 0 0 5px #00FF00, 0 0 10px #00FF00;
        }
        .logout-popup-inner p {
            color: #66FF66;
            margin-bottom: 20px;
        }
        .logout-popup-inner .flex {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .logout-popup-inner button {
            background-color: transparent;
            color: #00FF00;
            border: 2px solid #00FF00;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            letter-spacing: 1px;
            border-radius: 5px;
        }
        .logout-popup-inner button:hover {
            background-color: #00FF00;
            color: #000000;
            text-shadow: 0 0 5px #000000, 0 0 10px #000000;
        }
        .logout-popup-inner button:active {
            transform: scale(0.98);
        }
    </style>
    @yield('styles')
</head>

<body class="bg-gray-900">
    
    <div id="DashboardContent">
        
        @include('admin.components.header')
    
        <div class="flex">
    
            @include('admin.components.sidebar')
    
            <div class="flex-1 p-8">
                @yield('content')
            </div>
        </div>
        
        @include('admin.components.logout-popup')
    </div>

    <script>
        function togglePopup() {
            const popup = document.getElementById('logoutPopup');
            popup.classList.toggle('hidden');
        }
        
        function confirmLogout() {
            window.location.href = '/login';
        }
    </script>
    
    @yield('scripts')
</body>
</html>

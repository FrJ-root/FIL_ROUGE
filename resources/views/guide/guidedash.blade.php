<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Dashboard</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <div>
                    <span class="text-sm text-gray-600 mr-4">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 py-10 px-6 max-w-7xl mx-auto">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-2">Upcoming Trips</h3>
                    <p class="text-3xl font-bold text-blue-600">3</p>
                </div>
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-2">Active Travellers</h3>
                    <p class="text-3xl font-bold text-green-600">12</p>
                </div>
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-2">Pending Reviews</h3>
                    <p class="text-3xl font-bold text-yellow-600">5</p>
                </div>
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-2">Messages</h3>
                    <p class="text-3xl font-bold text-purple-600">8</p>
                </div>
            </div>

            <!-- Trips Table -->
            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-4">My Trips</h2>
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="py-2 px-4 font-medium text-gray-600">Trip Name</th>
                            <th class="py-2 px-4 font-medium text-gray-600">Date</th>
                            <th class="py-2 px-4 font-medium text-gray-600">Location</th>
                            <th class="py-2 px-4 font-medium text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">Desert Safari</td>
                            <td class="py-2 px-4">2025-04-10</td>
                            <td class="py-2 px-4">Sahara</td>
                            <td class="py-2 px-4"><span class="text-sm bg-blue-100 text-blue-700 px-2 py-1 rounded">Upcoming</span></td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">Atlas Hiking</td>
                            <td class="py-2 px-4">2025-04-15</td>
                            <td class="py-2 px-4">High Atlas</td>
                            <td class="py-2 px-4"><span class="text-sm bg-green-100 text-green-700 px-2 py-1 rounded">Confirmed</span></td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">Cultural Tour</td>
                            <td class="py-2 px-4">2025-04-20</td>
                            <td class="py-2 px-4">Marrakech</td>
                            <td class="py-2 px-4"><span class="text-sm bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>

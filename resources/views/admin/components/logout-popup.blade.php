<div id="logoutPopup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="logout-popup-inner">
        <h2 class="text-xl font-bold mb-4">Confirm Logout</h2>
        <p class="mb-4">Are you sure</p>
        <p class="mb-4">Mr admin</p>
        <p class="text-gray-500 mb-6">^_-</p>
        <div class="flex justify-center space-x-4">
            <button onclick="confirmLogout()" class="hover:bg-green-600">Yeep</button>
            <button onclick="togglePopup()" class="hover:bg-gray-500">Stay</button>
        </div>
    </div>
</div>

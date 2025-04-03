<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Youdemy - Admin Dashboard">
    <title>Youdemy - Admin Dashboard</title>
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
            border: 2px solidu0FF00;
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
</head>

<body class="bg-gray-900">
    
    <div id="welcomePopup" class="fixed inset-0 bg-black bg-opacity-90 flex justify-center items-center">
        <div class="welcome-popup-inner text-center">
            <h2 class="text-3xl font-bold text-green-400 mb-4 typing-effect">Welcome Mr. Admin</h2>
            <p class="text-green-300 text-lg mb-6 fade-in-effect">System Initializing...</p>
            <p class="text-gray-500 text-sm fade-in-effect-delay">Access Granted. Enjoy your session.</p>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const welcomePopup = document.getElementById('welcomePopup');        
                welcomePopup.style.display = 'flex';
                setTimeout(() => {
                    welcomePopup.classList.add('fade-out');
                    setTimeout(() => {
                        welcomePopup.remove();
                    }, 1000);
                }, 8000);
            });
        </script>

        <style>
            @keyframes typing {
                from { width: 0; }
                to { width: 100%; }
            }
            .typing-effect {
                overflow: hidden;
                white-space: nowrap;
                margin: 0 auto;
                letter-spacing: 0.15em;
                animation: typing 3s steps(40, end), blink-caret 0.75s step-end infinite;
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            .fade-in-effect {
                opacity: 0;
                animation: fadeIn 2s ease-in 3.5s forwards;
            }
            .fade-in-effect-delay {
                opacity: 0;
                animation: fadeIn 2s ease-in 5.5s forwards;
            }
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            .fade-out {
                animation: fadeOut 1s ease-in forwards;
            }
        </style>

    </div>

    <div id="DashboardContent">
        
        <div class="AdminPortal bg-gradient-to-r from-gray-900 via-black to-gray-900 relative">
            <div class="hex-pattern absolute inset-0 opacity-5"></div>
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center bg-black/50 rounded-lg px-4 py-2 border border-purple-500/20">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="ml-2 text-gray-300 font-medium">Admin Portal</span>
                        </div>
                        <div class="hidden md:flex items-center space-x-2">
                            <div class="h-2 w-2 rounded-full status-pulse"></div>
                            <span class="text-green-400 text-sm">System Status: Operational</span>
                        </div>
                    </div>
    
                    <div class="flex items-center space-x-4">
                        <div class="bg-black/30 rounded-lg px-4 py-2 text-sm">
                            <span class="text-gray-400">Session ID:</span>
                            <span class="text-purple-400 ml-2 font-mono">0xAF29B</span>
                        </div>
                        <div class="flex items-center bg-black/30 rounded-lg px-4 py-2">
                            <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                            <span class="text-green-400 text-sm font-medium typing">Active</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    
        <div class="flex">
    
            <div id="freeMovement" class="w-64 bg-black min-h-screen p-6">
    
                <div class="flex items-center gap-2 mb-8">
                    <div class="w-8 h-8 bg-purple-600 rounded flex items-center justify-center text-white">
                        <code class="text-sm">&lt;/&gt;</code>
                    </div>
                    <span class="text-xl font-bold text-purple-600">Dashboard</span>
                </div>
    
                <nav class="space-y-4">
    
                    <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
    
                    <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <span>Categories</span>
                    </a>
    
                    <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Tags</span>
                    </a>
    
                    <a href="#Allcourses" class="flex items-center gap-3 text-gray-400 hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Courses</span>
                    </a>
    
                    <a href="#account-validation" class="flex items-center gap-3 text-gray-400 hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Account Validation</span>
                    </a>
    
                    <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Setting</span>
                    </a>
    
                    <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Help</span>
                    </a>
    
                </nav>
    
                <a href="#" onclick="togglePopup()" class="flex items-center gap-3 text-gray-400 hover:text-gray-200 mt-8">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </a>
    
            </div>
    
            <div class="flex-1 p-8">
                
                <div id="Statistic" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    
                    <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-400">Total Courses</div>
                            <div class="bg-purple-500/10 rounded-full p-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-2xl font-bold text-white"><#####></span>
                            <span class="text-green-400 text-sm ml-2">+12%</span>
                        </div>
                    </div>
                
                    <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-400">Categories</div>
                            <div class="bg-purple-500/10 rounded-full p-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-2xl font-bold text-white"><#####></span>
                            <span class="text-green-400 text-sm ml-2">+3 new</span>
                        </div>
                    </div>
                
                    <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-400">Active Tags</div>
                            <div class="bg-purple-500/10 rounded-full p-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-2xl font-bold text-white"><#####></span>
                            <span class="text-yellow-400 text-sm ml-2">+5 trending</span>
                        </div>
                    </div>
                
                    <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-400">Students</div>
                            <div class="bg-purple-500/10 rounded-full p-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="mt-4">
                                <span class="text-2xl font-bold text-white"><#####></span>
                                <span class="text-green-400 text-sm ml-2">Act</span>
                            </div>
                            <div class="mt-4">
                                <span class="text-2xl font-bold text-white"><#####></span>
                                <span class="text-yellow-400 text-sm ml-2">Sus</span>
                            </div>
                            <div class="mt-4">
                                <span class="text-2xl font-bold text-white"><#####></span>
                                <span class="text-red-400 text-sm ml-2">Del</span>
                            </div>
                        </div>
                    </div>
                
                    <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-400">Enseignants</div>
                            <div class="bg-purple-500/10 rounded-full p-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex justify-around">
                            <div class="mt-4">
                                <span class="text-2xl font-bold text-white"><#####></span>
                                <span class="text-green-400 text-sm ml-2">Act</span>
                            </div>
                            <div class="mt-4">
                                <span class="text-2xl font-bold text-white"><#####></span>
                                <span class="text-yellow-400 text-sm ml-2">Sus</span>
                            </div>
                            <div class="mt-4">
                                <span class="text-2xl font-bold text-white"><#####></span>
                                <span class="text-red-400 text-sm ml-2">Del</span>
                            </div>
                        </div>
                    </div>
                
                </div>
    
                <div id="Category&Tags-Management" class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    
                    <div id="Category-Management" class="bg-gray-800 rounded-lg p-6 border border-purple-500/10">
    
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-white font-semibold">Category Management</div>
                            <div class="bg-purple-500/10 rounded-full p-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                        </div>
    
                        <form id="Add&Updatecategory" method="post">
                            <div class="flex gap-4 mb-6">
                                <input type="hidden" id="categoryId" name="categoryId" value="">
                                <input id="categoryInput" type="text" name="addcategory" placeholder="Enter category name..."
                                       class="flex-1 bg-gray-900 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                                <button type="submit" id="categoryButton"
                                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span id="buttonText">Add</span>
                                </button>
                                <button type="button" id="cancelButton" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md hidden">
                                    Cancel
                                </button>
                            </div>
                        </form>
    
                        <script id="tkhrbi9-CategoryInForm">
                            document.addEventListener('DOMContentLoaded', function () {
                                const categoryInput = document.getElementById('categoryInput');
                                const categoryIdInput = document.getElementById('categoryId');
                                const buttonText = document.getElementById('buttonText');
                                const cancelButton = document.getElementById('cancelButton');
                            
                                function populateFormForUpdate(categoryId, categoryTitle) {
                                    categoryIdInput.value = categoryId;
                                    categoryInput.value = categoryTitle;
                                    buttonText.textContent = 'Update';
                                    cancelButton.classList.remove('hidden');
                                }
                            
                                function resetFormForAdd() {
                                    categoryIdInput.value = '';
                                    categoryInput.value = '';
                                    buttonText.textContent = 'Add';
                                    cancelButton.classList.add('hidden');
                                }
                            
                                document.querySelectorAll('.update-category').forEach(button => {
                                    button.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        const categoryId = this.getAttribute('data-id');
                                        const categoryTitle = this.getAttribute('data-title');
                                        populateFormForUpdate(categoryId, categoryTitle);
                                    });
                                });
                            
                                cancelButton.addEventListener('click', function () {
                                    resetFormForAdd();
                                });
                            });
                        </script>
    
                        <div id="categories-list" class="flex flex-wrap gap-2">
                            
                        </div>
    
                    </div>
    
                    <div id="Tag-Management" class="bg-gray-800 rounded-lg p-6 border border-purple-500/10">
    
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-white font-semibold">Tag Management</div>
                            <div class="bg-purple-500/10 rounded-full p-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                </svg>
                            </div>
                        </div>
                        
                        <form id="Add&Updatetags" method="post">
                            <div class="flex gap-4 mb-6">
                                <input type="hidden" id="tagId" name="tagId" value="">
                                <input id="tagInput" type="text" name="addtag" placeholder="Enter tag name..."
                                       class="flex-1 bg-gray-900 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                                <button type="submit" id="tagButton" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span id="tagButtonText">Add</span>
                                </button>
                                <button type="button" id="tagCancelButton" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md hidden">
                                    Cancel
                                </button>
                            </div>
                        </form>
    
                        <script id="tkhrbi9-TagInForm">
                            document.addEventListener('DOMContentLoaded', function () {
                                const tagInput = document.getElementById('tagInput');
                                const tagIdInput = document.getElementById('tagId');
                                const buttonText = document.getElementById('tagButtonText');
                                const cancelButton = document.getElementById('tagCancelButton');
                            
                                function populateFormForUpdate(tagId, tagTitle) {
                                    tagIdInput.value = tagId;
                                    tagInput.value = tagTitle;
                                    buttonText.textContent = 'Update';
                                    cancelButton.classList.remove('hidden');
                                }
                            
                                function resetFormForAdd() {
                                    tagIdInput.value = '';
                                    tagInput.value = '';
                                    buttonText.textContent = 'Add';
                                    cancelButton.classList.add('hidden');
                                }
                            
                                document.querySelectorAll('.update-tag').forEach(button => {
                                    button.addEventListener('click', function (e) {
                                        e.preventDefault();
                                        const tagId = this.getAttribute('data-id');
                                        const tagTitle = this.getAttribute('data-title');
                                        populateFormForUpdate(tagId, tagTitle);
                                    });
                                });
                            
                                cancelButton.addEventListener('click', function () {
                                    resetFormForAdd();
                                });
                            });
                        </script>
    
                        <div id="tags-list" class="flex flex-wrap gap-2">
                            
                        </div>
    
                    </div>
    
                </div>
    
                <form id="CoursesFiltering" method="GET" action="" class="mb-8">
                    <div id="SearchFiltering" class="flex flex-col md:flex-row gap-4 mb-6">
                        <input type="text" 
                               name="search" 
                               placeholder="Search courses..." 
                               value=""
                               class="flex-1 bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                        
                        <select name="category" 
                                class="bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                            <option value="">All Categories</option>
                        </select>
    
                        <select name="tag" 
                                class="bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                            <option value="">All Tags</option>
                        </select>
                
                        <select name="filter" 
                                class="bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                            <option value="">Sort By</option>
                            <option value="newest">
                                Newest First
                            </option>
                            <option value="oldest">
                                Oldest First
                            </option>
                        </select>
                
                        <button type="submit" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md flex items-center justify-center gap-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search
                        </button>
                    </div>
                </form>
    
                <div id="Allcourses" class="space-y-4">
    
                    <div id="CategoryCounter" class="flex justify-between items-center mb-6"></div>
    
                    <h2 class="text-green-800 font-semibold mb-4">Active Courses</h2>
    
                   
                                <div class="flex items-center gap-4">
                                    <a href="#" class="edit-course text-gray-400 hover:text-yellow-400 transition-colors duration-200 relative group">
                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                   d="M7 17l5 5l5 -5M17 7l-5 -5l-5 5M5 12h14" />
                                         </svg>
                                         <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                             Edit
                                         </span>
                                    </a>
                                    <a href="" class="delete-course text-gray-400 hover:text-red-400 transition-colors duration-200 relative group">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            Delete
                                        </span>
                                    </a>
                                </div>
                            </div>
    
                    <div id="DeletedCourses" class="space-y-4 mt-8">
                        <h2 class="text-red-800 font-semibold mb-4">Deleted Courses</h2>

                    </div>
    
                </div>
    
                <div id="account-validation" class="space-y-4 mt-8">
                    <h2 class="text-purple-600 font-semibold mb-4">Account Validation</h2>
                
                    <div id="StudentAccounts" class="bg-gray-800 p-6 rounded-lg">
                        <h3 class="text-white font-semibold mb-4">Student Accounts</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-gray-900">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-400">Username</th>
                                        <th class="px-4 py-2 text-left text-gray-400">Field</th>
                                        <th class="px-4 py-2 text-left text-gray-400">Status</th>
                                        <th class="px-4 py-2 text-left text-gray-400">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded">
                                                        Update
                                                    </button>
                                </tbody>
                            </table>
                        </div>
                    </div>
                
                    <div id="EnseignantAccounts" class="bg-gray-800 p-6 rounded-lg">
                        <h3 class="text-white font-semibold mb-4">Enseignant Accounts</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-gray-900">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-400">Username</th>
                                        <th class="px-4 py-2 text-left text-gray-400">Speciality</th>
                                        <th class="px-4 py-2 text-left text-gray-400">Status</th>
                                        <th class="px-4 py-2 text-left text-gray-400">Actions</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
    
                </div>
    
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('.delete-course').forEach(button => {
                            button.addEventListener('click', function (e) {
                                e.preventDefault();
                                const courseId = this.getAttribute('data-id');
                                if (confirm('Are you sure you want to delete this course?')) {
                                    fetch(`../courses/deleteCourse.php?id=${courseId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                alert(data.message);
                                                this.closest('.course-card').remove();
                                            } else {
                                                alert(data.message);
                                            }
                                        }).catch(error => console.error('Error:', error));
                                }
                            });
                        });
                    });
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('.restore-course').forEach(button => {
                            button.addEventListener('click', function (e) {
                                e.preventDefault();
                                const courseId = this.getAttribute('data-id');
                                if (confirm('Are you sure you want to restore this course?')) {
                                    fetch(`../courses/restoreCourse.php?id=${courseId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                window.location.href = "../admin/Dashboard.php";
                                            } else {
                                                alert(data.message);
                                            }
                                        }).catch(error => console.error('Error:', error));
                                }
                            });
                        });
                    });
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('form[action="./acounts/updateStatus.php"]').forEach(form => {
                            form.addEventListener('submit', function (e) {
                                e.preventDefault();
                    
                                const formData = new FormData(this);
                    
                                fetch(this.action, {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert(data.message);
                                        window.location.reload();
                                    } else {
                                        alert(data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                            });
                        });
                    });
                </script>
    
            </div>
    
        </div>
        
        <div id="logoutPopup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
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

    </div>

    <script>
        function togglePopup() {
        const popup = document.getElementById('logoutPopup');
        popup.classList.toggle('hidden');
        }
        function confirmLogout() {
        window.location.href = '/login';
        }
        document.getElementById('add-category-button').addEventListener('click', function(e) {
        const categoryInput = document.getElementById('category-input').value;
        if (!categoryInput) {
            e.preventDefault();
            alert("Please enter a category name.");
        }
        });
    </script>

</body>
</html>
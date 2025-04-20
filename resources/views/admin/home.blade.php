@include('admin.components.welcome-popup')

@extends('admin.layouts.admin-layout')

@section('title', 'Admin Home')

@section('content')
<div class="p-6 bg-gray-800 rounded-lg border border-purple-500/10">
    <div class="flex flex-col items-center mb-10">
        <div class="relative mb-6">
            <div class="w-32 h-32 rounded-full border-3 border-purple-500 overflow-hidden relative">
                <img src="{{ asset('assets/images/admin.jpg') }}" alt="Admin" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/default-admin.jpg') }}'; this.onerror=null;">
                <div class="absolute inset-0 bg-gradient-to-b from-purple-500/10 to-green-500/20 mix-blend-overlay"></div>
                <div class="absolute inset-0 bg-black/30 mix-blend-color-burn"></div>
            </div>
            <div class="absolute -bottom-1 -right-1 bg-green-500 w-6 h-6 rounded-full border-2 border-gray-800"></div>
            <div class="absolute inset-0 rounded-full border-3 border-purple-500/50 animate-pulse"></div>
            <div class="absolute inset-0 flex items-center justify-center opacity-30">
                <div class="text-xs text-green-400 font-mono select-none" style="font-size: 8px;">
                    01010110<br>10101011<br>01101010
                </div>
            </div>
        </div>
        
        <div class="flex items-center">
            <div class="bg-purple-500/10 rounded-full p-3 mr-4">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">Welcome to Admin Portal</h1>
                <p class="text-gray-400 mt-1">Manage your travel platform effectively</p>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-black/20 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
            <h2 class="text-xl font-semibold text-white mb-4">Quick Navigation</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-gray-300 hover:text-purple-400 p-3 rounded-md hover:bg-black/30 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 text-gray-300 hover:text-purple-400 p-3 rounded-md hover:bg-black/30 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.tags') }}" class="flex items-center gap-3 text-gray-300 hover:text-purple-400 p-3 rounded-md hover:bg-black/30 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Tags</span>
                </a>
                <a href="{{ route('admin.account-validation') }}" class="flex items-center gap-3 text-gray-300 hover:text-purple-400 p-3 rounded-md hover:bg-black/30 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Account Validation</span>
                </a>
            </div>
        </div>

        <div class="bg-black/20 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
            <h2 class="text-xl font-semibold text-white mb-4">System Status</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Server Status</span>
                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-200 text-green-800">Operational</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Database</span>
                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-200 text-green-800">Connected</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Last Backup</span>
                    <span class="text-gray-300">{{ now()->subHours(6)->format('Y-m-d H:i') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Active Sessions</span>
                    <span class="text-gray-300">{{ rand(1, 5) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-black/20 rounded-lg p-6 border border-purple-500/10">
        <h2 class="text-xl font-semibold text-white mb-4">Recent Activity</h2>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="h-8 w-8 rounded-full bg-blue-500/20 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-300">New user registered</p>
                    <p class="text-gray-500 text-sm">{{ now()->subMinutes(rand(5, 59))->diffForHumans() }}</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="h-8 w-8 rounded-full bg-green-500/20 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-300">Account validated: travel company</p>
                    <p class="text-gray-500 text-sm">{{ now()->subHours(rand(1, 3))->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

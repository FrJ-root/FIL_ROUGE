@extends('admin.layouts.admin-layout')

@section('title', 'statistics')

@section('content')
    <div id="Statistic" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">Total Trips</div>
                <div class="bg-purple-500/10 rounded-full p-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-white">{{ $totalTrips ?? 0 }}</span>
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
                <span class="text-2xl font-bold text-white">{{ $totalCategories ?? 0 }}</span>
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
                <span class="text-2xl font-bold text-white">{{ $activeTags ?? 0 }}</span>
                <span class="text-yellow-400 text-sm ml-2">+5 trending</span>
            </div>
        </div>
    
        <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">Travellers</div>
                <div class="bg-purple-500/10 rounded-full p-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $activeTravellers ?? 0 }}</span>
                    <span class="text-green-400 text-sm ml-2">Act</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $suspendedTravellers ?? 0 }}</span>
                    <span class="text-yellow-400 text-sm ml-2">Sus</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $deletedTravellers ?? 0 }}</span>
                    <span class="text-red-400 text-sm ml-2">Blc</span>
                </div>
            </div>
        </div>
    
        <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">TransportCompany</div>
                <div class="bg-purple-500/10 rounded-full p-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $activeTransports ?? 0 }}</span>
                    <span class="text-green-400 text-sm ml-2">Act</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $suspendedTransports ?? 0 }}</span>
                    <span class="text-yellow-400 text-sm ml-2">Sus</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $deletedTransports ?? 0 }}</span>
                    <span class="text-red-400 text-sm ml-2">Blc</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">Guides</div>
                <div class="bg-purple-500/10 rounded-full p-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $activeGuides ?? 0 }}</span>
                    <span class="text-green-400 text-sm ml-2">Act</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $suspendedGuides ?? 0 }}</span>
                    <span class="text-yellow-400 text-sm ml-2">Sus</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $deletedGuides ?? 0 }}</span>
                    <span class="text-red-400 text-sm ml-2">Blc</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">Hotels</div>
                <div class="bg-purple-500/10 rounded-full p-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $activeHotels ?? 0 }}</span>
                    <span class="text-green-400 text-sm ml-2">Act</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $suspendedHotels ?? 0 }}</span>
                    <span class="text-yellow-400 text-sm ml-2">Sus</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $deletedHotels ?? 0 }}</span>
                    <span class="text-red-400 text-sm ml-2">Blc</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">Managers</div>
                <div class="bg-purple-500/10 rounded-full p-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $activeManagers ?? 0 }}</span>
                    <span class="text-green-400 text-sm ml-2">Act</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $suspendedManagers ?? 0 }}</span>
                    <span class="text-yellow-400 text-sm ml-2">Sus</span>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-white">{{ $deletedManagers ?? 0 }}</span>
                    <span class="text-red-400 text-sm ml-2">Blc</span>
                </div>
            </div>
        </div>
    </div>
@endsection
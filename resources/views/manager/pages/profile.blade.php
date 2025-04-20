@extends('manager.layouts.manager')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-user-circle text-manager-primary mr-3"></i>
        My Profile
    </h1>
    <a href="{{ route('manager.profile.edit') }}" class="bg-manager-primary hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow-md transition-colors flex items-center">
        <i class="fas fa-edit mr-2"></i> Edit Profile
    </a>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="md:flex">
        <div class="md:flex-shrink-0 bg-gradient-to-b from-manager-primary to-purple-700 text-white p-8 md:w-64">
            <div class="flex flex-col items-center">
                @if(Auth::user()->picture)
                    <img src="{{ asset('storage/' . Auth::user()->picture) }}" 
                        alt="Profile Picture" 
                        class="w-32 h-32 rounded-full border-4 border-white shadow-lg hover:scale-105 transition-transform duration-300 object-cover">
                @else
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg flex items-center justify-center bg-white text-manager-primary text-4xl font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <h2 class="text-xl font-bold mt-4">{{ Auth::user()->name }}</h2>
                <p class="text-purple-200">Trip Manager</p>
                
                <div class="mt-6 w-full">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-envelope w-6 text-purple-300"></i>
                        <span class="ml-2 text-sm">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-shield w-6 text-purple-300"></i>
                        <span class="ml-2 text-sm capitalize">{{ Auth::user()->role }}</span>
                    </div>
                    <div class="flex items-center mb-3">
                        <i class="fas fa-calendar-check w-6 text-purple-300"></i>
                        <span class="ml-2 text-sm">Joined {{ Auth::user()->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-8 flex-1">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Account Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Account Status</h4>
                    <div class="flex items-center">
                        @if(Auth::user()->status === 'valide')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i> Pending
                            </span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Last Login</h4>
                    <p class="text-gray-600">{{ now()->format('M d, Y h:i A') }}</p>
                </div>
            </div>
            
            <div class="mt-10">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-tasks text-manager-secondary mr-2"></i> Management Summary
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="rounded-full bg-blue-100 text-blue-500 p-3 mr-4">
                                <i class="fas fa-route"></i>
                            </div>
                            <div>
                                <h4 class="text-gray-900 font-medium">Total Trips</h4>
                                <p class="text-2xl font-bold text-gray-800">{{ App\Models\Trip::count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="rounded-full bg-green-100 text-green-500 p-3 mr-4">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h4 class="text-gray-900 font-medium">Travellers</h4>
                                <p class="text-2xl font-bold text-gray-800">{{ App\Models\Traveller::count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="rounded-full bg-purple-100 text-purple-500 p-3 mr-4">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div>
                                <h4 class="text-gray-900 font-medium">Partners</h4>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ App\Models\Hotel::count() + App\Models\Guide::count() + App\Models\Transport::count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-200">
                <a href="{{ route('manager.profile.edit') }}" class="text-manager-primary hover:text-purple-700 flex items-center text-sm font-medium">
                    <i class="fas fa-edit mr-2"></i> Edit your profile information
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

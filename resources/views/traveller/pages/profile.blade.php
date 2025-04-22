@extends('traveller.layouts.profile')

@section('profile_content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md transform transition-all duration-500 animate-fade-in-down" role="alert">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative h-48 bg-gradient-to-r from-blue-500 to-indigo-600">
                    <div class="absolute bottom-0 left-0 w-full transform translate-y-1/2 flex justify-center">
                        @if($user->picture)
                            <img class="h-24 w-24 rounded-full border-4 border-white object-cover shadow-lg" 
                                src="{{ asset('storage/' . $user->picture) }}" 
                                alt="{{ $user->name }}">
                        @else
                            <div class="h-24 w-24 rounded-full border-4 border-white bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="pt-16 pb-6 px-6 text-center">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                    <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    
                    @if($traveller && $traveller->nationality)
                        <div class="mt-3 inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            <span class="flag-icon flag-icon-{{ strtolower($traveller->nationality) }} mr-1"></span>
                            {{ $traveller->nationality }}
                        </div>
                    @endif
                    
                    <div class="mt-6 flex justify-center">
                        <a href="{{ route('traveller.profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Travel Stats -->
            <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-indigo-600">
                    <h2 class="text-lg font-bold text-white flex items-center">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Travel Stats
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-indigo-600">{{ $traveller->trip_id ? 1 : 0 }}</div>
                            <div class="text-sm text-gray-500">Current Trip</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ rand(1, 10) }}</div>
                            <div class="text-sm text-gray-500">Completed</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ rand(2, 5) }}</div>
                            <div class="text-sm text-gray-500">Countries</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ rand(50, 500) }}</div>
                            <div class="text-sm text-gray-500">Travel Points</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="md:col-span-2">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center">
                    <svg class="h-6 w-6 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h2 class="text-lg font-bold text-white">Personal Information</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nationality</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $traveller->nationality ?? 'Not specified' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Passport Number</dt>
                            <dd class="mt-1 text-lg text-gray-900">
                                @if($traveller && $traveller->passport_number)
                                    <span class="font-mono">{{ substr($traveller->passport_number, 0, 2) }}***********</span>
                                @else
                                    Not specified
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <!-- Travel Preferences -->
            <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="px-6 py-4 bg-gradient-to-r from-teal-500 to-blue-500 flex items-center">
                    <svg class="h-6 w-6 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    <h2 class="text-lg font-bold text-white">Travel Preferences</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Preferred Destination</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $traveller->prefered_destination ?? 'Not specified' }}</dd>
                        </div>
                        
                        <!-- Travel Interests visualization -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-2">Travel Interests</dt>
                            <dd>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $interests = ['Beach', 'Mountain', 'City', 'Cultural', 'Adventure', 'Food', 'Wildlife', 'Relaxation'];
                                        $colors = ['blue', 'green', 'indigo', 'purple', 'red', 'yellow', 'pink', 'teal'];
                                    @endphp
                                    
                                    @foreach(array_slice($interests, 0, 5) as $index => $interest)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $colors[$index] }}-100 text-{{ $colors[$index] }}-800">
                                            {{ $interest }}
                                        </span>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Travel Map -->
            <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-orange-500 flex items-center">
                    <svg class="h-6 w-6 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <h2 class="text-lg font-bold text-white">Places I've Visited</h2>
                </div>
                <div class="p-6 aspect-video bg-gray-200 rounded-lg relative overflow-hidden">
                    <div class="absolute inset-0 opacity-50 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1526778548025-fa2f459cd5ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <p class="text-gray-900 text-center px-4 py-2 bg-white/80 rounded-lg shadow-sm backdrop-blur-sm">
                            <svg class="inline-block h-5 w-5 text-indigo-600 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Enable travel mapping by adding your past destinations in profile settings!
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Trip -->
            @if($traveller && $traveller->trip_id)
                <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-teal-500 flex items-center">
                        <svg class="h-6 w-6 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-lg font-bold text-white">Upcoming Trip</h2>
                    </div>
                    <div class="p-6">
                        @php
                            $trip = $traveller->trip;
                        @endphp
                        @if($trip)
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden">
                                    @if($trip->cover_picture)
                                        <img src="{{ asset('storage/images/trip/' . $trip->cover_picture) }}" alt="{{ $trip->destination }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-indigo-100 text-indigo-500">
                                            <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $trip->destination }}</h3>
                                    <div class="text-sm text-gray-500">
                                        {{ date('M d, Y', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('trips.show', $trip->id) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                            View Trip Details
                                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">No upcoming trips planned yet.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .animate-fade-in-down {
        animation: fade-in-down 0.5s ease-out;
    }

    @keyframes fade-in-down {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Add smooth hover transitions */
    .hover-lift {
        transition: transform 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@push('scripts')
<script>
    // Add any JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Fade in elements one by one
        const elements = document.querySelectorAll('.animate-on-load');
        elements.forEach((element, index) => {
            setTimeout(() => {
                element.classList.add('opacity-100');
                element.classList.remove('opacity-0');
            }, 100 * index);
        });
    });
</script>
@endpush

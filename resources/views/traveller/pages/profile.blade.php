@extends('traveller.layouts.profile')

@section('profile_content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center space-x-5">
                <div class="flex-shrink-0">
                    <div class="relative">
                        @if($user->picture)
                            <img class="h-20 w-20 rounded-full object-cover" 
                                src="{{ asset('storage/' . $user->picture) }}" 
                                alt="{{ $user->name }}">
                        @else
                            <img class="h-20 w-20 rounded-full" 
                                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=3b82f6&color=ffffff" 
                                alt="{{ $user->name }}">
                        @endif
                        <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-sm font-medium text-gray-500">{{ $user->email }}</p>
                </div>
                <div class="ml-auto flex-shrink-0">
                    <a href="{{ route('traveller.profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit Profile
                    </a>
                </div>
            </div>

            <div class="mt-6 border-t border-gray-200 pt-6">
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
                        <dl class="mt-4 space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email address</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nationality</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $traveller->nationality ?? 'Not specified' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Passport Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $traveller->passport_number ?? 'Not specified' }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Preferences</h2>
                        <dl class="mt-4 space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Preferred Destination</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $traveller->prefered_destination ?? 'Not specified' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t border-gray-200 pt-6">
                <h2 class="text-lg font-medium text-gray-900">Account Information</h2>
                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Member since</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection

@extends('guide.layouts.guide')

@section('content')
<h1 class="text-2xl font-bold mb-6">Guide Profile</h1>
<div class="bg-white shadow rounded-xl p-6">
    <div class="flex items-center mb-6">
        <img src="{{ Auth::user()->picture ? asset('storage/' . Auth::user()->picture) : asset('images/default-profile.png') }}" 
             alt="Profile Picture" 
                 class="w-32 h-32 rounded-full border-4 border-blue-500 mr-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
            <p class="text-sm text-gray-600">{{ $guide->specialization ?? 'Specialization not set' }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700">License Number</h3>
            <p class="text-gray-600">{{ $guide->license_number ?? 'Not provided' }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700">Availability</h3>
            <p class="text-gray-600">{{ $guide->availability ?? 'Not set' }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700">Preferred Locations</h3>
            <p class="text-gray-600">{{ $guide->preferred_locations ?? 'Not specified' }}</p>
        </div>
    </div>
    <a href="{{ route('guide.profile.edit') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300">
        Edit Profile
    </a>
</div>
@endsection

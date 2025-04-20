@extends('manager.layouts.manager')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-key text-manager-primary mr-3"></i>
        Change Password
    </h1>
    <a href="{{ route('manager.profile') }}" class="text-gray-600 hover:text-manager-primary flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Profile
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <p>{{ session('success') }}</p>
    </div>
</div>
@endif

@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <div>
            <p class="font-bold">Please fix the following errors:</p>
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-manager-primary to-purple-600 text-white p-6">
        <h2 class="text-xl font-bold">Update Your Password</h2>
        <p class="text-purple-200 mt-1">Enter your current password and choose a new secure password</p>
    </div>
    
    <form method="POST" action="{{ route('manager.profile.password.update') }}" class="p-6">
        @csrf
        
        <div class="mb-6">
            <label for="current_password" class="block text-gray-700 font-bold mb-2">Current Password</label>
            <input type="password" name="current_password" id="current_password" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-manager-primary focus:border-manager-primary">
            <p class="text-sm text-gray-500 mt-1">Enter your current password to verify your identity</p>
        </div>
        
        <div class="mb-6">
            <label for="password" class="block text-gray-700 font-bold mb-2">New Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-manager-primary focus:border-manager-primary">
            <p class="text-sm text-gray-500 mt-1">Choose a strong password (at least 8 characters)</p>
        </div>
        
        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-manager-primary focus:border-manager-primary">
        </div>
        
        <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('manager.profile') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                Cancel
            </a>
            <button type="submit" class="bg-manager-primary hover:bg-purple-700 text-white font-bold py-2 px-6 rounded shadow-md transform transition-transform hover:scale-105">
                <i class="fas fa-save mr-2"></i> Update Password
            </button>
        </div>
    </form>
</div>
@endsection

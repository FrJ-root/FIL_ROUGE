@extends('layouts.app')

<div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md mx-auto">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('https://images.unsplash.com/photo-1503220317375-aaad61436b1b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');"></div>
    
    <div class="relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Your Travel Account</h2>
            <p class="text-gray-600">Join us and start planning your dream trips around the world!</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Full Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus 
                        class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
                        placeholder="Enter your full name">
                </div>
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                        class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
                        placeholder="Enter your email">
                </div>
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password" id="password" required 
                        class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
                        placeholder="Create a password">
                </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                        class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
                        placeholder="Confirm your password">
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-center mb-6">
                <input type="checkbox" name="terms" id="terms" class="rounded border-gray-300 text-blue-500 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                <label for="terms" class="ml-2 text-gray-700">I agree to the <a href="#" class="text-blue-500 hover:text-blue-700">Terms of Service</a> and <a href="#" class="text-blue-500 hover:text-blue-700">Privacy Policy</a></label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-600 transition-colors duration-300 flex justify-center items-center">
                <i class="fas fa-user-plus mr-2"></i> Create Account
            </button>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 font-medium">Sign in</a></p>
            </div>

            <!-- Social Login Section -->
            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300">
                <span class="px-4 text-gray-500 text-sm">OR REGISTER WITH</span>
                <hr class="flex-grow border-gray-300">
            </div>

            <!-- Social Login Buttons -->
            <div class="flex space-x-4">
                <a href="#" class="flex-1 bg-blue-600 text-white py-3 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors">
                    <i class="fab fa-facebook-f mr-2"></i> Facebook
                </a>
                <a href="#" class="flex-1 bg-red-600 text-white py-3 rounded-lg flex items-center justify-center hover:bg-red-700 transition-colors">
                    <i class="fab fa-google mr-2"></i> Google
                </a>
            </div>
        </form>
    </div>
</div>
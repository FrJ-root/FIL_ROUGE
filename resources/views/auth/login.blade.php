@extends('layouts.app')

@section('content')

<div class="bg-gradient-to-br from-blue-50 to-teal-50 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md mx-auto border-t-4 border-teal-500">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="bg-teal-100 p-3 rounded-full">
                    <i class="fas fa-plane text-teal-600 text-2xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h2>
            <p class="text-gray-600">Sign in to your account to continue your journey</p>
        </div>
        
        @if ($errors->any())
            <div class="@if(session('status_type') === 'block') bg-red-100 border border-red-400 text-red-700 @elseif(session('status_type') === 'suspend') bg-yellow-100 border border-yellow-400 text-yellow-700 @else bg-red-100 border border-red-400 text-red-700 @endif px-4 py-3 rounded mb-4">
                @if($errors->has('status'))
                    <div class="flex items-center mb-2">
                        <i class="@if(session('status_type') === 'block') fas fa-ban text-red-500 @elseif(session('status_type') === 'suspend') fas fa-pause-circle text-yellow-500 @else fas fa-exclamation-circle @endif mr-2"></i>
                        <p class="font-bold">Account Status Alert</p>
                    </div>
                    <p>{{ $errors->first('status') }}</p>
                    <div class="mt-2 text-sm">
                        <p>If you believe this is an error, please contact customer support:</p>
                        <p class="mt-1"><i class="fas fa-envelope mr-1"></i> support@tripydb.com</p>
                    </div>
                @else
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="login-form" onsubmit="return validateLoginForm()">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-teal-500"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus 
                        class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-black"
                        placeholder="Enter your email">
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-gray-700 font-medium">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-teal-500 hover:text-teal-700">Forgot Password?</a>
                    @endif
                </div>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-teal-500"></i>
                    <input type="password" name="password" id="password" required 
                        class="w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 text-black"
                        placeholder="Enter your password">
                </div>
            </div>
            
            <div class="flex items-center mb-6">
                <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-teal-500 focus:border-teal-500 focus:ring focus:ring-teal-200">
                <label for="remember" class="ml-2 text-gray-700">Remember me</label>
            </div>
            
            <button type="submit" class="w-full bg-teal-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-teal-700 transition-colors duration-300 flex justify-center items-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
            </button>
            
            <div class="text-center mt-6">
                <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-teal-500 hover:text-teal-700 font-medium">Sign up</a></p>
            </div>
            
            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300">
                <span class="px-4 text-gray-500 text-sm">OR CONTINUE WITH</span>
                <hr class="flex-grow border-gray-300">
            </div>
            
            <div class="flex space-x-4">
                <a href="#" class="flex-1 bg-blue-600 text-white py-3 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors">
                    <i class="fab fa-facebook-f mr-2"></i> Facebook
                </a>
                <a href="#" class="flex-1 bg-white border border-gray-300 text-gray-700 py-3 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                    <i class="fab fa-google mr-2 text-red-500"></i> Google
                </a>
            </div>
        </form>
        
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex justify-center space-x-6 text-xs text-gray-500">
                <span class="flex items-center">
                    <i class="fas fa-map-marker-alt text-teal-500 mr-1"></i> Destinations
                </span>
                <span class="flex items-center">
                    <i class="fas fa-hotel text-teal-500 mr-1"></i> Hotels
                </span>
                <span class="flex items-center">
                    <i class="fas fa-suitcase text-teal-500 mr-1"></i> Trips
                </span>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<script>
    function validateLoginForm() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(el => el.remove());
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!email.value.trim() || !emailRegex.test(email.value)) {
            showHackerError(email, 'You look like a Hacker ^_-');
            return false;
        }
        
        if (!password.value || password.value.length < 6) {
            showHackerError(password, 'You look like a Hacker ^_-');
            return false;
        }
        
        if (containsSuspiciousPatterns(email.value) || containsSuspiciousPatterns(password.value)) {
            showHackerError(email, 'You look like a Hacker ^_-');
            return false;
        }
        
        return true;
    }
    
    function containsSuspiciousPatterns(input) {
        const suspiciousPatterns = [
            '<script>', 'javascript:', 'onerror=', 'onclick=', 
            'onload=', 'alert(', '--', '/*', '*/', 'SELECT ', 
            'DROP ', 'DELETE ', 'UPDATE '
        ];
        const lowerInput = input.toLowerCase();
        return suspiciousPatterns.some(pattern => lowerInput.includes(pattern));
    }
    
    function showHackerError(inputElement, message) {
        const existingError = inputElement.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-500 text-sm mt-1 animate-pulse font-medium';
        errorDiv.innerHTML = `<i class="fas fa-user-secret mr-1"></i>${message}`;
        inputElement.parentNode.appendChild(errorDiv);
        inputElement.classList.add('border-red-500');
        inputElement.focus();
        
        return false;
    }
</script>
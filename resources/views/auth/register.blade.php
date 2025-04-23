@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-auto relative overflow-hidden border border-gray-100">

       <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-100 rounded-full opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-100 rounded-full opacity-50"></div>
        
        @php
            $fromTripWithUs = request()->has('trip_id');
            $redirectUrl = request()->input('redirect');
            $tripId = request()->input('trip_id');
        @endphp

        <style>
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
            .animate-pulse-custom {
                animation: pulse 2s infinite;
            }
            
            .role-radio:checked + .role-radio-circle .role-radio-dot {
                display: block !important;
            }
            
            .step-enter {
                opacity: 0;
                transform: translateX(20px);
            }
            .step-enter-active {
                opacity: 1;
                transform: translateX(0);
                transition: opacity 300ms, transform 300ms;
            }
        </style>

        <div class="mb-8">
            <div class="relative pt-1">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <span id="step-text" class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-indigo-600 bg-indigo-200">
                            Step <span id="current-step-number">1</span> of 3
                        </span>
                    </div>
                    <div class="text-right">
                        <span id="progress-percentage" class="text-xs font-semibold inline-block text-indigo-600">
                            33%
                        </span>
                    </div>
                </div>
                <div class="flex h-2 mb-4 overflow-hidden text-xs bg-indigo-200 rounded">
                    <div id="progress-bar" style="width:33%" class="flex flex-col justify-center text-center text-white bg-indigo-600 shadow-none transition-all duration-500"></div>
                </div>
                
                <div class="flex justify-between">
                    <div id="step-indicator-1" class="flex flex-col items-center">
                        <div class="w-6 h-6 mb-1 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xs">1</div>
                        <span class="text-xs">Start</span>
                    </div>
                    <div id="step-indicator-2" class="flex flex-col items-center">
                        <div class="w-6 h-6 mb-1 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-xs">2</div>
                        <span class="text-xs">Role</span>
                    </div>
                    <div id="step-indicator-3" class="flex flex-col items-center">
                        <div class="w-6 h-6 mb-1 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-xs">3</div>
                        <span class="text-xs">Details</span>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" id="register-form" onsubmit="return validateRegistrationForm()" class="relative z-10">
            @csrf

            <div id="step1" class="step transition-all duration-500 transform">
                <div class="text-center mb-8">
                    <div class="inline-block p-3 rounded-full bg-indigo-100 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-3">Start Your Journey</h2>
                    <p class="text-gray-600 mb-4">Join our community and discover amazing travel experiences around the world!</p>
                    
                    @if ($errors->any())
                        <div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-200 text-left">
                            <ul class="list-disc pl-4 text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <button type="button" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-xl flex items-center justify-center" onclick="nextStep()">
                    <span>Get Started</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div id="step2" class="step hidden transition-all duration-500 transform">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">I am a...</h2>
                @if(!$fromTripWithUs)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    @foreach([
                        ['Hotel', 'Building with rooms for travelers'],
                        ['Transport', 'Company providing travel services'],
                        ['Traveller', 'Explorer seeking new experiences'],
                        ['Guide', 'Expert sharing local knowledge'],
                    ] as [$role, $description])
                        <label class="role-option cursor-pointer flex flex-col p-4 border-2 border-gray-200 rounded-xl text-gray-700 hover:border-indigo-500 hover:bg-indigo-50 transition-all duration-200 group">
                            <input type="radio" name="role" value="{{ strtolower(explode(' ', $role)[0]) }}" class="hidden role-radio" required>
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center group-hover:border-indigo-500 transition-colors role-radio-circle">
                                    <div class="hidden w-3 h-3 bg-indigo-500 rounded-full role-radio-dot"></div>
                                </div>
                                <span class="font-medium text-lg">{{ $role }}</span>
                            </div>
                            <p class="text-sm text-gray-500 pl-9">{{ $description }}</p>
                        </label>
                    @endforeach
                </div>
                @else
                <input type="hidden" name="role" value="traveller">
                
                <div class="rounded-md bg-indigo-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-indigo-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-indigo-800">Trip Registration</h3>
                            <div class="mt-2 text-sm text-indigo-700">
                                <p>You're registering to join a trip to {{ $tripId ? \App\Models\Trip::find($tripId)->destination ?? 'your destination' : 'your destination' }}. After registration, you'll complete your booking.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(request()->has('trip_id'))
                    <input type="hidden" name="trip_id" value="{{ request('trip_id') }}">
                @endif

                @if(request()->has('redirect'))
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                @endif

                <div class="flex justify-between space-x-4">
                    <button type="button" class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 px-4 rounded-xl hover:bg-gray-200 transition-all duration-300 flex items-center justify-center" onclick="prevStep()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </button>
                    <button type="button" id="role-continue-btn" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 opacity-50 cursor-not-allowed flex items-center justify-center" onclick="validateAndContinue()" disabled>
                        Continue
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="step3" class="step hidden transition-all duration-500 transform">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Complete Your Profile</h2>

                <div class="mb-5">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" name="name" id="name" required 
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 hover:border-indigo-300"
                            placeholder="Your full name">
                    </div>
                    <div id="name-error" class="text-red-500 text-xs mt-1 hidden">Please enter your full name</div>
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <input type="email" name="email" id="email" required 
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 hover:border-indigo-300"
                            placeholder="your.email@example.com">
                    </div>
                    <div id="email-error" class="text-red-500 text-xs mt-1 hidden">Please enter a valid email address</div>
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        <input type="password" name="password" id="password" required 
                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 hover:border-indigo-300"
                            placeholder="Create a secure password">
                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div id="password-strength" class="h-1.5 rounded-full bg-red-500" style="width: 0%"></div>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-500">Weak</span>
                            <span class="text-xs text-gray-500">Strong</span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 hover:border-indigo-300"
                            placeholder="Confirm your password">
                    </div>
                </div>

                <div class="flex justify-between space-x-4">
                    <button type="button" class="flex-1 bg-gray-100 text-gray-700 font-medium py-3 px-4 rounded-xl hover:bg-gray-200 transition-all duration-300 flex items-center justify-center" onclick="prevStep()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </button>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold py-3 px-4 rounded-xl shadow-md hover:shadow-lg transform transition-all duration-300 hover:scale-[1.02] flex items-center justify-center group">
                        <span>Complete Registration</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">
                                Or continue with
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="{{ url('login/google') }}" 
                           class="w-full inline-flex justify-center items-center py-3 px-4 rounded-md shadow-sm bg-white hover:bg-gray-50 border border-gray-200 transition-all duration-200 hover:shadow-md transform hover:-translate-y-1">
                            <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                                    <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"/>
                                    <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"/>
                                    <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"/>
                                    <path fill="#EA4335" d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"/>
                                </g>
                            </svg>
                            <span class="text-gray-700 font-medium">Google</span>
                        </a>

                        <a href="{{ url('login/facebook') }}" 
                           class="w-full inline-flex justify-center items-center py-3 px-4 rounded-md shadow-sm bg-[#4267B2] hover:bg-[#3b5998] text-white border border-[#4267B2] transition-all duration-200 hover:shadow-md transform hover:-translate-y-1">
                            <svg class="h-5 w-5 mr-2 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.19795 21.5H13.198V13.4901H16.8021L17.198 9.50977H13.198V7.5C13.198 6.94772 13.6457 6.5 14.198 6.5H17.198V2.5H14.198C11.4365 2.5 9.19795 4.73858 9.19795 7.5V9.50977H7.19795L6.80206 13.4901H9.19795V21.5Z"/>
                            </svg>
                            <span class="font-medium">Facebook</span>
                        </a>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}?{{ http_build_query(request()->query()) }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Sign in
                        </a>
                    </p>
                </div>

            </div>

        </form>

        <div id="validation-popup" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg hidden">
            <p id="validation-message" class="text-sm"></p>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;
        const totalSteps = 3;
        const fromTripWithUs = {{ $fromTripWithUs ? 'true' : 'false' }};
        
        const progressBar = document.getElementById('progress-bar');
        const progressPercentage = document.getElementById('progress-percentage');
        const currentStepNumber = document.getElementById('current-step-number');
        const stepText = document.getElementById('step-text');
        
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        
        const stepIndicator1 = document.getElementById('step-indicator-1');
        const stepIndicator2 = document.getElementById('step-indicator-2');
        const stepIndicator3 = document.getElementById('step-indicator-3');
        
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');
        const passwordStrength = document.getElementById('password-strength');
        
        const roleOptions = document.querySelectorAll('.role-option');
        const roleRadios = document.querySelectorAll('input[name="role"]');
        const roleContinueBtn = document.getElementById('role-continue-btn');
        
        if (step1) step1.classList.remove('hidden');
        if (step2) step2.classList.add('hidden');
        if (step3) step3.classList.add('hidden');
        
        function updateProgress(step) {
            const percentage = Math.round((step / totalSteps) * 100);
            if (progressBar) progressBar.style.width = percentage + '%';
            if (progressPercentage) progressPercentage.textContent = percentage + '%';
            if (currentStepNumber) currentStepNumber.textContent = step;
            
            if (stepIndicator1) {
                stepIndicator1.querySelector('div').className = step >= 1 
                    ? 'w-6 h-6 mb-1 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xs' 
                    : 'w-6 h-6 mb-1 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-xs';
            }
            
            if (stepIndicator2) {
                stepIndicator2.querySelector('div').className = step >= 2 
                    ? 'w-6 h-6 mb-1 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xs' 
                    : 'w-6 h-6 mb-1 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-xs';
            }
            
            if (stepIndicator3) {
                stepIndicator3.querySelector('div').className = step >= 3 
                    ? 'w-6 h-6 mb-1 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xs animate-pulse-custom' 
                    : 'w-6 h-6 mb-1 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-xs';
            }
        }
        
        function showStep(step) {
            if (step1) step1.classList.add('hidden');
            if (step2) step2.classList.add('hidden');
            if (step3) step3.classList.add('hidden');
            
            if (step === 1 && step1) step1.classList.remove('hidden');
            if (step === 2 && step2) step2.classList.remove('hidden');
            if (step === 3 && step3) step3.classList.remove('hidden');
            
            updateProgress(step);
            currentStep = step;
        }
        
        window.nextStep = function() {
            if (fromTripWithUs && currentStep === 1) {
                showStep(3);
                return;
            }
            
            if (currentStep < totalSteps) {
                showStep(currentStep + 1);
            }
        };
        
        window.prevStep = function() {
            if (fromTripWithUs && currentStep === 3) {
                showStep(1);
                return;
            }
            
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        };
        
        window.validateAndContinue = function() {
            if (fromTripWithUs) {
                nextStep();
                return;
            }
            
            const selectedRole = document.querySelector('input[name="role"]:checked');
            if (selectedRole) {
                nextStep();
            } else {
                roleOptions.forEach(option => {
                    option.classList.add('border-red-500');
                    setTimeout(() => {
                        option.classList.remove('border-red-500');
                    }, 1000);
                });
                alert('Please select a role to continue');
            }
        };
        
        if (roleOptions) {
            roleOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        roleRadios.forEach(r => r.checked = false);
                        
                        radio.checked = true;
                        
                        roleOptions.forEach(opt => {
                            opt.classList.remove('border-indigo-500', 'bg-indigo-50');
                            const dot = opt.querySelector('.role-radio-dot');
                            if (dot) dot.classList.add('hidden');
                        });
                        
                        this.classList.add('border-indigo-500', 'bg-indigo-50');
                        const dot = this.querySelector('.role-radio-dot');
                        if (dot) dot.classList.remove('hidden');
                        
                        if (roleContinueBtn) {
                            roleContinueBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            roleContinueBtn.disabled = false;
                        }
                    }
                });
            });
        }
        
        if (passwordField) {
            passwordField.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength += 25;
                if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
                if (password.match(/\d/)) strength += 25;
                if (password.match(/[^a-zA-Z\d]/)) strength += 25;
                if (passwordStrength) {
                    passwordStrength.style.width = strength + '%';
                    if (strength < 50) {
                        passwordStrength.classList.remove('bg-yellow-500', 'bg-green-500');
                        passwordStrength.classList.add('bg-red-500');
                    } else if (strength < 75) {
                        passwordStrength.classList.remove('bg-red-500', 'bg-green-500');
                        passwordStrength.classList.add('bg-yellow-500');
                    } else {
                        passwordStrength.classList.remove('bg-red-500', 'bg-yellow-500');
                        passwordStrength.classList.add('bg-green-500');
                    }
                }
            });
        }
        
        if (confirmPasswordField && passwordField) {
            confirmPasswordField.addEventListener('input', function() {
                if (this.value !== passwordField.value) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-300');
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                }
            });
        }
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (currentStep === 3) {
                    if (passwordField && confirmPasswordField && passwordField.value !== confirmPasswordField.value) {
                        e.preventDefault();
                        alert('Password and confirmation do not match!');
                        confirmPasswordField.focus();
                        return false;
                    }
                    if (passwordField && passwordField.value.length < 8) {
                        e.preventDefault();
                        alert('Password must be at least 8 characters long!');
                        passwordField.focus();
                        return false;
                    }
                }
                
                return true;
            });
        }
        
        const togglePassword = document.getElementById('togglePassword');
        if (togglePassword && passwordField) {
            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                const eyeIcon = this.querySelector('svg');
                if (eyeIcon) {
                    if (type === 'password') {
                        eyeIcon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />';
                    } else {
                        eyeIcon.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 00-2.79.588l.77.771A5.944 5.944 0 018 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0114.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z" /><path d="M11.297 9.176a3.5 3.5 0 00-4.474-4.474l.823.823a2.5 2.5 0 012.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 01-4.474-4.474l.823.823a2.5 2.5 0 002.829 2.829z" /><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 001.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 018 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709z" /><path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z" clip-rule="evenodd" />';
                    }
                }
            });
        }
        
        updateProgress(1);
    });

    function validateRegistrationForm() {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const popup = document.getElementById('validation-popup');
        const message = document.getElementById('validation-message');

        popup.classList.add('hidden');

        if (!name.value.trim()) {
            showPopup('Name is required');
            return false;
        }

        if (!email.value.trim()) {
            showPopup('Email is required');
            return false;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            showPopup('Please enter a valid email address');
            return false;
        }

        if (!password.value.trim()) {
            showPopup('Password is required');
            return false;
        }
        if (password.value.length < 6) {
            showPopup('Password must be at least 6 characters long');
            return false;
        }

        if (password.value !== passwordConfirmation.value) {
            showPopup('Passwords do not match');
            return false;
        }

        return true;
    }

    function showPopup(messageText) {
        const popup = document.getElementById('validation-popup');
        const message = document.getElementById('validation-message');
        message.textContent = messageText;
        
        popup.classList.remove('hidden');
        popup.classList.add('animate-bounce');
        
        setTimeout(() => {
            popup.classList.remove('animate-bounce');
            popup.classList.add('transition-opacity', 'duration-500', 'opacity-0');
            
            setTimeout(() => {
                popup.classList.add('hidden');
                popup.classList.remove('transition-opacity', 'duration-500', 'opacity-0');
            }, 500);
        }, 3000);
    }
    
    document.querySelectorAll('button[type="button"]').forEach(button => {
        if (button.textContent.includes('Continue') || button.textContent.includes('Get Started')) {
            button.addEventListener('click', function() {
                if (currentStep === 2 && !document.querySelector('input[name="role"]:checked')) {
                    showPopup('Please select a role to continue');
                    return false;
                }
            });
        }
    });
    
    document.getElementById('name')?.addEventListener('blur', function() {
        if (!this.value.trim()) {
            showPopup('Name is required');
            this.classList.add('border-red-500');
        } else {
            this.classList.remove('border-red-500');
        }
    });
    
    document.getElementById('email')?.addEventListener('blur', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.value.trim()) {
            showPopup('Email is required');
            this.classList.add('border-red-500');
        } else if (!emailRegex.test(this.value)) {
            showPopup('Please enter a valid email address');
            this.classList.add('border-red-500');
        } else {
            this.classList.remove('border-red-500');
        }
    });
</script>

@endsection
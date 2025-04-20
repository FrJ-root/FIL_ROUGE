@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-auto relative overflow-hidden border border-gray-100">

       <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-100 rounded-full opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-100 rounded-full opacity-50"></div>
        
        <div class="relative z-10 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex flex-col items-center">
                    <div id="step1-indicator" class="w-10 h-10 rounded-full flex items-center justify-center border-2 border-indigo-500 bg-indigo-500 text-white font-bold transition-all duration-300">1</div>
                    <span class="text-xs font-medium mt-1 text-gray-600">Welcome</span>
                </div>
                <div class="flex-1 h-1 mx-2 bg-gray-200 relative">
                    <div id="progress-1-2" class="absolute top-0 left-0 h-full bg-indigo-500 transition-all duration-500" style="width: 0%"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div id="step2-indicator" class="w-10 h-10 rounded-full flex items-center justify-center border-2 border-gray-300 text-gray-400 font-bold transition-all duration-300">2</div>
                    <span class="text-xs font-medium mt-1 text-gray-600">Role</span>
                </div>
                <div class="flex-1 h-1 mx-2 bg-gray-200 relative">
                    <div id="progress-2-3" class="absolute top-0 left-0 h-full bg-indigo-500 transition-all duration-500" style="width: 0%"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div id="step3-indicator" class="w-10 h-10 rounded-full flex items-center justify-center border-2 border-gray-300 text-gray-400 font-bold transition-all duration-300">3</div>
                    <span class="text-xs font-medium mt-1 text-gray-600">Details</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="relative z-10">
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

                <a href="{{ url('login/google') }}" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-xl flex items-center justify-center">
                    <span>Login with Google</span>
                </a>

                <a href="{{ url('login/facebook') }}" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-xl flex items-center justify-center">
                    <span>Login with Facebook</span>
                </a>

            </div>

            <div class="text-center mt-8 text-sm text-gray-500">
                Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Sign in here</a>
            </div>

        </form>

    </div>
</div>

<script>

    let currentStep = 1;

    function updateProgressBar() {
        document.getElementById('step1-indicator').classList.toggle('bg-indigo-500', currentStep >= 1);
        document.getElementById('step1-indicator').classList.toggle('text-white', currentStep >= 1);
        document.getElementById('step1-indicator').classList.toggle('border-indigo-500', currentStep >= 1);
        document.getElementById('step2-indicator').classList.toggle('bg-indigo-500', currentStep >= 2);
        document.getElementById('step2-indicator').classList.toggle('text-white', currentStep >= 2);
        document.getElementById('step2-indicator').classList.toggle('border-indigo-500', currentStep >= 2);
        document.getElementById('step2-indicator').classList.toggle('border-gray-300', currentStep < 2);
        document.getElementById('step2-indicator').classList.toggle('text-gray-400', currentStep < 2);
        document.getElementById('step3-indicator').classList.toggle('bg-indigo-500', currentStep >= 3);
        document.getElementById('step3-indicator').classList.toggle('text-white', currentStep >= 3);
        document.getElementById('step3-indicator').classList.toggle('border-indigo-500', currentStep >= 3);
        document.getElementById('step3-indicator').classList.toggle('border-gray-300', currentStep < 3);
        document.getElementById('step3-indicator').classList.toggle('text-gray-400', currentStep < 3);
        document.getElementById('progress-1-2').style.width = currentStep >= 2 ? '100%' : '0%';
        document.getElementById('progress-2-3').style.width = currentStep >= 3 ? '100%' : '0%';
    }

    function showStep(step) {

        currentStep = step;
        
        document.querySelectorAll('.step').forEach((el) => {

            el.classList.add('hidden');

            el.classList.remove('scale-105', 'opacity-0');
        });
        
        const currentStepEl = document.getElementById('step' + step);

        currentStepEl.classList.remove('hidden');
        
        setTimeout(() => {

            currentStepEl.classList.remove('opacity-0', 'scale-95');

            currentStepEl.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        updateProgressBar();
    }

    function nextStep() {

        if (currentStep < 3) {
            const currentStepEl = document.getElementById('step' + currentStep);

            currentStepEl.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {

                currentStep++;
                showStep(currentStep);
            }, 300);
        }
    }

    function prevStep() {

        if (currentStep > 1) {
            const currentStepEl = document.getElementById('step' + currentStep);

            currentStepEl.classList.add('scale-105', 'opacity-0');
            
            setTimeout(() => {

                currentStep--;
                showStep(currentStep);

            }, 300);
        }
    }
    
    function validateAndContinue() {

        if (document.querySelector('input[name="role"]:checked')) {
            nextStep();
        }
    }
    
    document.querySelectorAll('.role-option').forEach(option => {

        option.addEventListener('click', function() {

            document.querySelectorAll('.role-option').forEach(opt => {

                opt.classList.remove('border-indigo-500', 'bg-indigo-50');

                opt.querySelector('.role-radio-dot').classList.add('hidden');
            });
            
            this.classList.add('border-indigo-500', 'bg-indigo-50');

            this.querySelector('.role-radio-dot').classList.remove('hidden');

            this.querySelector('input[type="radio"]').checked = true;
            
            document.getElementById('role-continue-btn').classList.remove('opacity-50', 'cursor-not-allowed');

            document.getElementById('role-continue-btn').removeAttribute('disabled');
        });
    });
    
    document.getElementById('togglePassword').addEventListener('click', function() {

        const passwordInput = document.getElementById('password');

        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        
        passwordInput.setAttribute('type', type);
        
        const eyeIcon = this.querySelector('svg');

        if (type === 'text') {
            eyeIcon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />';
       
        } else {
            eyeIcon.innerHTML = '<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />';
        }
    });
    
    document.getElementById('password').addEventListener('input', function() {

        const password = this.value;

        let strength = 0;

        if (password.length >= 8) strength += 1;

        if (/[A-Z]/.test(password)) strength += 1;

        if (/[0-9]/.test(password)) strength += 1;

        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        
        const strengthBar = document.getElementById('password-strength');

        strengthBar.style.width = (strength * 25) + '%';
        
        if (strength === 0) {
            strengthBar.className = 'h-1.5 rounded-full bg-gray-300';

        } else if (strength === 1) {
            strengthBar.className = 'h-1.5 rounded-full bg-red-500';

        } else if (strength === 2) {
            strengthBar.className = 'h-1.5 rounded-full bg-orange-500';

        } else if (strength === 3) {
            strengthBar.className = 'h-1.5 rounded-full bg-yellow-500';

        } else {
            strengthBar.className = 'h-1.5 rounded-full bg-green-500';
        }
    });

    showStep(currentStep);

</script>

@endsection
@extends('layouts.app')

@section('content')
    @include('components.sidebar')
    <div 
        x-data="{ sidebarCollapsed: true }"
        @sidebar-state-changed.window="sidebarCollapsed = $event.detail.isCollapsed"
        :class="{'md:ml-64': !sidebarCollapsed, 'md:ml-16': sidebarCollapsed}"
        class="transition-all duration-300" 
        id="main-content"
    >
        <div class="container mx-auto px-4 py-8 mt-16">
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center mb-8">
                    <a href="{{ route('trips.index') }}" class="text-gray-600 hover:text-indigo-600 transition-colors mr-4 group flex items-center">
                        <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> 
                        <span class="border-b border-transparent group-hover:border-indigo-600">Back to Trips</span>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-plus-circle text-indigo-600 mr-3"></i>Create New Trip
                    </h1>
                </div>

                @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-5 mb-6 rounded-lg shadow-md animate-fade-in" role="alert">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3 mt-0.5"></i>
                        <div>
                            <h3 class="font-bold mb-2">Please fix the following errors:</h3>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-route mr-2"></i> Trip Details
                        </h2>
                        <p class="text-indigo-100 text-sm">Fill in the information below to create a new trip</p>
                    </div>

                    <form method="POST" action="{{ route('trips.store') }}" enctype="multipart/form-data" id="tripForm" class="p-6 space-y-8" onsubmit="return validateTripForm()">
                        @csrf
                        
                        <input type="hidden" name="debug_info" value="form_submission_test">
                        
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i> Destination Information
                            </h3>
                            
                            <div class="mb-5">
                                <label for="destination" class="block text-gray-700 font-medium mb-2">
                                    Destination <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-globe-americas text-gray-400"></i>
                                    </div>
                                    <input type="text" name="destination" id="destination" value="{{ old('destination') }}" 
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                        placeholder="Where are you going? (e.g., Paris, France)" required>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Enter a city, country, or region for this trip</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="start_date" class="block text-gray-700 font-medium mb-2">
                                        Start Date <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar-alt text-gray-400"></i>
                                        </div>
                                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" 
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                            required min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <div>
                                    <label for="end_date" class="block text-gray-700 font-medium mb-2">
                                        End Date <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar-check text-gray-400"></i>
                                        </div>
                                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" 
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                            required min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-th-large text-indigo-500 mr-2"></i> Trip Categories
                            </h3>
                            <p class="text-gray-600 mb-4">Select categories that best describe this trip</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($categories as $category)
                                <div class="flex items-center space-x-3 bg-gray-50 hover:bg-indigo-50 p-3 rounded-lg border border-gray-200 transition-colors cursor-pointer group">
                                    <input type="checkbox" id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}"
                                           class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label for="category-{{ $category->id }}" class="flex-1 text-gray-700 cursor-pointer group-hover:text-indigo-700 transition-colors">{{ $category->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-tags text-indigo-500 mr-2"></i> Trip Tags
                            </h3>
                            <p class="text-gray-600 mb-4">Add specific tags to make your trip more discoverable</p>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <select name="tags[]" id="tags" multiple class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" size="5">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-sm text-gray-500 mt-2 flex items-center">
                                    <i class="fas fa-info-circle mr-1 text-indigo-400"></i>
                                    Hold Ctrl (Windows) or Command (Mac) to select multiple tags
                                </p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-image text-indigo-500 mr-2"></i> Cover Image
                            </h3>
                            
                            <div x-data="{ fileName: null, filePreview: null }">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 border-dashed">
                                    <div class="text-center" x-show="!filePreview">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-2"></i>
                                        <p class="text-gray-600 mb-3">Drag and drop an image here or click to browse</p>
                                        <div class="relative">
                                            <input type="file" name="cover_picture" id="cover_picture" 
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                accept="image/*"
                                                @change="
                                                    fileName = $event.target.files[0].name;
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => {
                                                        filePreview = e.target.result;
                                                    };
                                                    reader.readAsDataURL($event.target.files[0]);
                                                ">
                                            <button type="button" class="bg-indigo-100 text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-200 transition-colors">
                                                Select Image
                                            </button>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-2">JPG, PNG or GIF - Max size 2MB</p>
                                    </div>
                                    
                                    <div x-show="filePreview" class="relative">
                                        <img :src="filePreview" class="mx-auto max-h-64 rounded-lg shadow-md">
                                        <div class="mt-3 flex items-center justify-center">
                                            <span x-text="fileName" class="text-sm text-gray-600 mr-2"></span>
                                            <button type="button" @click="filePreview = null; document.getElementById('cover_picture').value = ''" 
                                                    class="text-red-500 hover:text-red-700 text-sm">
                                                <i class="fas fa-times-circle"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('trips.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transform transition-all duration-300 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center cursor-pointer z-10 relative"
                            onclick="this.classList.add('opacity-75'); this.innerHTML = '<i class=\'fas fa-spinner fa-spin mr-2\'></i> Creating...';">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Create Trip
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                endDateInput.min = startDateInput.value;
                if (endDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                    endDateInput.value = startDateInput.value;
                }
            });
        }
        
        const categoryCheckboxes = document.querySelectorAll('input[name="categories[]"]');
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const parentEl = this.closest('.bg-gray-50');
                if (this.checked) {
                    parentEl.classList.add('bg-indigo-50', 'border-indigo-200');
                    parentEl.classList.remove('bg-gray-50', 'border-gray-200');
                } else {
                    parentEl.classList.remove('bg-indigo-50', 'border-indigo-200');
                    parentEl.classList.add('bg-gray-50', 'border-gray-200');
                }
            });
        });

        document.getElementById('tripForm').addEventListener('submit', function(e) {
            console.log('Form submitted!');
            
            const requiredFields = this.querySelectorAll('[required]');
            let allFilled = true;
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    console.error('Required field not filled:', field.name);
                    allFilled = false;
                }
            });
            
            if (!allFilled) {
                e.preventDefault();
                alert('Please fill all required fields.');
            }
        });
        const form = document.getElementById('tripForm');
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.style.pointerEvents = 'auto';
        submitButton.style.position = 'relative';
        submitButton.style.zIndex = '100';
        
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Submit button clicked');
            
            const isValid = form.checkValidity();
            
            if (isValid) {
                console.log('Form is valid, submitting...');
                form.submit();
            } else {
                console.log('Form validation failed');
                form.reportValidity();
            }
        });
        
        form.addEventListener('submit', function(event) {
            console.log('Form submitted', {
                action: this.action,
                method: this.method,
                enctype: this.enctype
            });
            
            let formData = {};
            new FormData(this).forEach((value, key) => {
                if (key !== 'cover_picture') {
                    formData[key] = value;
                } else {
                    formData[key] = value.name;
                }
            });
            console.log('Form data:', formData);
        });
    });

    function validateTripForm() {
        const destination = document.getElementById('destination');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        if (!destination.value.trim()) {
            showError(destination, 'Destination is required');
            return false;
        } else if (destination.value.trim().length < 3) {
            showError(destination, 'Destination must be at least 3 characters');
            return false;
        }
        if (!startDate.value) {
            showError(startDate, 'Start date is required');
            return false;
        }
        
        if (!endDate.value) {
            showError(endDate, 'End date is required');
            return false;
        }
        
        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        
        if (end < start) {
            showError(endDate, 'End date must be after or equal to start date');
            return false;
        }
        
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 30) {
            if (!confirm('This trip is longer than 30 days. Are you sure this is correct?')) {
                return false;
            }
        }
        
        return true;
    }
    
    function showError(inputElement, message) {
        const existingError = inputElement.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-500 text-sm mt-1';
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
        inputElement.parentNode.after(errorDiv);
        inputElement.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
        inputElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        inputElement.focus();
    }
</script>
@endpush

@push('styles')
<style>
    @keyframes fade-in {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
    
    select[multiple] {
        overflow-y: auto;
        scrollbar-width: thin;
    }
    
    select[multiple] option {
        padding: 8px 12px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
    }
    
    select[multiple] option:hover {
        background-color: #EEF2FF;
    }
    
    select[multiple] option:checked {
        background-color: #C7D2FE !important;
        color: #4F46E5;
    }
</style>
@endpush
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
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center mb-6">
                    <a href="{{ route('trips.index') }}" class="text-gray-600 hover:text-red-500 mr-4">
                        <i class="fas fa-arrow-left"></i> Back to Trips
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800">Create New Trip</h1>
                </div>

                @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Please fix the following errors:</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Simplified form - no Alpine.js for submission state -->
                <form method="POST" action="{{ route('trips.store') }}" class="bg-white rounded-lg shadow-md p-6" enctype="multipart/form-data" id="tripForm">
                    @csrf
                    <div class="mb-4">
                        <label for="destination" class="block text-gray-700 font-bold mb-2">
                            Destination <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="destination" id="destination" value="{{ old('destination') }}" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                            placeholder="Where are you going?" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="start_date" class="block text-gray-700 font-bold mb-2">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                                required min="{{ date('Y-m-d') }}">
                        </div>

                        <div>
                            <label for="end_date" class="block text-gray-700 font-bold mb-2">
                                End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                                required min="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="cover_picture" class="block text-gray-700 font-bold mb-2">Cover Image (Optional)</label>
                        <input type="file" name="cover_picture" id="cover_picture" 
                            class="w-full px-4 py-2 border rounded-lg" 
                            accept="image/*">
                    </div>

                    <div class="mt-6">
                        <!-- Simplified submit button without Alpine.js -->
                        <button 
                            type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg transition-colors w-full cursor-pointer font-bold" 
                            id="submitButton"
                            onclick="console.log('Submit button clicked');"
                        >
                            <i class="fas fa-plane-departure mr-2"></i> Create Trip
                        </button>
                    </div>
                </form>

                <!-- Debugging info -->
                <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                    <p class="text-gray-700 font-semibold">Troubleshooting Info:</p>
                    <ul class="list-disc list-inside text-sm text-gray-600 mt-2">
                        <li>Form Action: <span class="text-blue-600">{{ route('trips.store') }}</span></li>
                        <li>Method: <span class="text-blue-600">POST</span></li>
                        <li>Enctype: <span class="text-blue-600">multipart/form-data</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Track form submission
        const form = document.getElementById('tripForm');
        const submitButton = document.getElementById('submitButton');
        
        console.log('DOM loaded, form found:', !!form);
        console.log('Submit button found:', !!submitButton);
        
        if (form) {
            // Log when the form is submitted
            form.addEventListener('submit', function(event) {
                console.log('Form is being submitted');
                // No preventDefault() to allow normal form submission
            });
        }
        
        if (submitButton) {
            // Add extra click handler to make sure clicks are detected
            submitButton.addEventListener('click', function(event) {
                console.log('Submit button was clicked');
            });
        }
        ent.getElementById('tripForm');
        // Set minimum end_date based on start_date
        const startDateInput = document.getElementById('start_date');.log('Trip form found, attaching event listener');
        const endDateInput = document.getElementById('end_date');
        
        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                endDateInput.min = startDateInput.value;
                if (endDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                    endDateInput.value = startDateInput.value;function updateFileDisplay(input) {
                }nt.getElementById('preview-container');
            });.getElementById('empty-container');
        }
    });
</script>
@endpush    const reader = new FileReader();

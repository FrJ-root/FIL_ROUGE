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

                <form action="{{ route('trips.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="destination" class="block text-gray-700 font-bold mb-2">Destination</label>
                        <input type="text" name="destination" id="destination" value="{{ old('destination') }}" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                            placeholder="Where are you going?" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="start_date" class="block text-gray-700 font-bold mb-2">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                                required min="{{ date('Y-m-d') }}">
                        </div>

                        <div>
                            <label for="end_date" class="block text-gray-700 font-bold mb-2">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" 
                                required min="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="cover_picture" class="block text-gray-700 font-bold mb-2">Cover Image (Optional)</label>
                        <input type="file" name="cover_picture" id="cover_picture" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                            accept="image/*">
                        <p class="text-sm text-gray-500 mt-1">Upload an image to use as the trip cover photo.</p>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-colors w-full">
                            <i class="fas fa-plane-departure mr-2"></i> Create Trip
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Set minimum end_date based on start_date
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

        // Sidebar observer
        const sidebarWrapper = document.querySelector('.sidebar-wrapper');
        if (sidebarWrapper) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'x-data') {
                        const sidebarData = Alpine.raw(Alpine.$data(sidebarWrapper));
                        const mainContent = document.getElementById('main-content');
                        
                        if (sidebarData && mainContent) {
                            if (sidebarData.isCollapsed) {
                                mainContent.classList.remove('md:ml-64');
                                mainContent.classList.add('md:ml-16');
                            } else {
                                mainContent.classList.remove('md:ml-16');
                                mainContent.classList.add('md:ml-64');
                            }
                        }
                    }
                });
            });
            
            observer.observe(sidebarWrapper, { attributes: true });
        }
    });
</script>
@endpush

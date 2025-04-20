@extends('transport.layouts.transport')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-edit text-transport-blue mr-3"></i>
            Edit Company Profile
        </h1>
        <a href="{{ route('transport.profile') }}" class="flex items-center text-transport-blue hover:underline">
            <i class="fas fa-arrow-left mr-2"></i> Back to Profile
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <p class="font-bold">Please fix these errors:</p>
            </div>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('transport.update-profile') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-6">
                    <label for="company_name" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-building text-transport-blue mr-2"></i>
                        Company Name
                    </label>
                    <input type="text" id="company_name" name="company_name" 
                           value="{{ old('company_name', $transport->company_name ?? '') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-transport-blue focus:border-transport-blue p-3 border"
                           placeholder="Enter your company name">
                </div>

                <div class="mb-6">
                    <label for="license_number" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-id-card text-transport-blue mr-2"></i>
                        License Number
                    </label>
                    <input type="text" id="license_number" name="license_number" 
                           value="{{ old('license_number', $transport->license_number ?? '') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-transport-blue focus:border-transport-blue p-3 border"
                           placeholder="Enter your transport license number">
                </div>

                <div class="mb-6">
                    <label for="transport_type" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-truck text-transport-blue mr-2"></i>
                        Transport Type
                    </label>
                    <select id="transport_type" name="transport_type" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-transport-blue focus:border-transport-blue p-3 border">
                        <option value="Tourist vehicle" {{ (old('transport_type', $transport->transport_type ?? '') == 'Tourist vehicle') ? 'selected' : '' }}>Tourist vehicle</option>
                        <option value="Plane" {{ (old('transport_type', $transport->transport_type ?? '') == 'Plane') ? 'selected' : '' }}>Plane</option>
                        <option value="Train" {{ (old('transport_type', $transport->transport_type ?? '') == 'Train') ? 'selected' : '' }}>Train</option>
                        <option value="Horse" {{ (old('transport_type', $transport->transport_type ?? '') == 'Horse') ? 'selected' : '' }}>Horse</option>
                        <option value="Camel" {{ (old('transport_type', $transport->transport_type ?? '') == 'Camel') ? 'selected' : '' }}>Camel</option>
                        <option value="Bus" {{ (old('transport_type', $transport->transport_type ?? '') == 'Bus') ? 'selected' : '' }}>Bus</option>
                    </select>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-6">
                    <label for="address" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-transport-blue mr-2"></i>
                        Address
                    </label>
                    <input type="text" id="address" name="address" 
                           value="{{ old('address', $transport->address ?? '') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-transport-blue focus:border-transport-blue p-3 border"
                           placeholder="Enter your business address">
                </div>

                <div class="mb-6">
                    <label for="phone" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone text-transport-blue mr-2"></i>
                        Phone Number
                    </label>
                    <input type="text" id="phone" name="phone" 
                           value="{{ old('phone', $transport->phone ?? '') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-transport-blue focus:border-transport-blue p-3 border"
                           placeholder="Enter your contact phone">
                </div>

                <div class="mb-6">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-camera text-transport-blue mr-2"></i>
                        Profile Picture
                    </label>
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <img src="{{ Auth::user()->picture ? asset('storage/' . Auth::user()->picture) : asset('images/default-profile.png') }}" 
                                 alt="Current Profile" 
                                 class="w-20 h-20 rounded-full border-4 border-white shadow-md">
                            <div class="absolute -bottom-2 -right-2 bg-white p-1 rounded-full shadow">
                                <i class="fas fa-truck text-transport-blue text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" id="picture" name="picture" 
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-transport-blue/10 file:text-transport-blue
                                          hover:file:bg-transport-blue/20">
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF (Max 2MB)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
            <button type="button" onclick="window.location='{{ route('transport.profile') }}'" 
                    class="mr-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300">
                Cancel
            </button>
            <button type="submit" 
                    class="bg-transport-blue hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                <i class="fas fa-save mr-2"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    // Preview image before upload
    document.getElementById('picture').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('img[alt="Current Profile"]').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

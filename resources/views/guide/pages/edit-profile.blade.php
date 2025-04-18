@extends('guide.layouts.guide')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-user-edit text-adventure-blue mr-3"></i>
        Edit Your Profile
    </h1>
    <a href="{{ route('guide.profile') }}" class="flex items-center text-adventure-blue hover:underline">
        <i class="fas fa-arrow-left mr-2"></i> Back to Profile
    </a>
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

    <form method="POST" action="{{ route('guide.profile.update') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-6">
                    <label for="license_number" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-id-card text-adventure-blue mr-2"></i>
                        License Number
                    </label>
                    <input type="text" id="license_number" name="license_number" 
                           value="{{ old('license_number', $guide->license_number) }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-adventure-blue focus:border-adventure-blue p-3 border"
                           placeholder="Enter your official guide license number">
                </div>

                <div class="mb-6">
                    <label for="specialization" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-star text-adventure-orange mr-2"></i>
                        Specialization
                    </label>
                    <input type="text" id="specialization" name="specialization" 
                           value="{{ old('specialization', $guide->specialization) }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-adventure-blue focus:border-adventure-blue p-3 border"
                           placeholder="e.g., Desert Tours, Cultural Heritage, Hiking">
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-6">
                    <label for="preferred_locations" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marked-alt text-adventure-green mr-2"></i>
                        Preferred Locations
                    </label>
                    <textarea id="preferred_locations" name="preferred_locations" rows="3" 
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-adventure-blue focus:border-adventure-blue p-3 border"
                              placeholder="List the regions you're most experienced in">{{ old('preferred_locations', $guide->preferred_locations) }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-camera text-adventure-blue mr-2"></i>
                        Profile Picture
                    </label>
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <img src="{{ Auth::user()->picture ? asset('storage/' . Auth::user()->picture) : asset('images/default-profile.png') }}" 
                                 alt="Current Profile" 
                                 class="w-20 h-20 rounded-full border-4 border-white shadow-md">
                            <div class="absolute -bottom-2 -right-2 bg-white p-1 rounded-full shadow">
                                <i class="fas fa-user text-adventure-blue text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" id="picture" name="picture" 
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-adventure-blue/10 file:text-adventure-blue
                                          hover:file:bg-adventure-blue/20">
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF (Max 2MB)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
            <button type="button" onclick="window.location='{{ route('guide.profile') }}'" 
                    class="mr-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300">
                Cancel
            </button>
            <button type="submit" 
                    class="bg-adventure-green hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
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
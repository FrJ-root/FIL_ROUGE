@extends('hotel.layouts.hotel')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-hotel text-hotel-blue mr-3"></i>
        Edit Hotel Profile
    </h1>
    <a href="{{ route('hotel.profile') }}" class="flex items-center text-hotel-blue hover:underline">
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

    <form method="POST" action="{{ route('hotel.profile.update') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-6">
                    <label for="name" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-building text-hotel-blue mr-2"></i>
                        Hotel Name
                    </label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name', $hotel->name ?? '') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                           placeholder="Enter your hotel name" required>
                </div>

                <div class="mb-6">
                    <label for="address" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-hotel-blue mr-2"></i>
                        Address
                    </label>
                    <input type="text" id="address" name="address" 
                           value="{{ old('address', $hotel->address ?? '') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                           placeholder="Enter full street address" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <label for="city" class="block text-lg font-semibold text-gray-700 mb-2">
                            <i class="fas fa-city text-hotel-blue mr-2"></i>
                            City
                        </label>
                        <input type="text" id="city" name="city" 
                               value="{{ old('city', $hotel->city ?? '') }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                               placeholder="Enter city" required>
                    </div>

                    <div class="mb-6">
                        <label for="country" class="block text-lg font-semibold text-gray-700 mb-2">
                            <i class="fas fa-globe text-hotel-blue mr-2"></i>
                            Country
                        </label>
                        <input type="text" id="country" name="country" 
                               value="{{ old('country', $hotel->country ?? '') }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                               placeholder="Enter country" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="star_rating" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-star text-hotel-orange mr-2"></i>
                        Star Rating
                    </label>
                    <select id="star_rating" name="star_rating" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                            required>
                        <option value="">Select Star Rating</option>
                        <option value="1" {{ (old('star_rating', $hotel->star_rating ?? '') == 1) ? 'selected' : '' }}>1 Star</option>
                        <option value="2" {{ (old('star_rating', $hotel->star_rating ?? '') == 2) ? 'selected' : '' }}>2 Stars</option>
                        <option value="3" {{ (old('star_rating', $hotel->star_rating ?? '') == 3) ? 'selected' : '' }}>3 Stars</option>
                        <option value="4" {{ (old('star_rating', $hotel->star_rating ?? '') == 4) ? 'selected' : '' }}>4 Stars</option>
                        <option value="5" {{ (old('star_rating', $hotel->star_rating ?? '') == 5) ? 'selected' : '' }}>5 Stars</option>
                    </select>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-6">
                    <label for="price_per_night" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-hotel-green mr-2"></i>
                        Base Price Per Night
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                        <input type="number" id="price_per_night" name="price_per_night" 
                               value="{{ old('price_per_night', $hotel->price_per_night ?? '') }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 pl-8 border"
                               placeholder="0.00" min="0" step="0.01" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-hotel-blue mr-2"></i>
                        Hotel Description
                    </label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                              placeholder="Describe your hotel, its features and unique selling points" required>{{ old('description', $hotel->description ?? '') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-concierge-bell text-hotel-orange mr-2"></i>
                        Hotel Amenities
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        @php
                            $amenitiesList = ['WiFi', 'Swimming Pool', 'Parking', 'Restaurant', 'Room Service', 'Spa', 'Gym', 'Air Conditioning', 'Bar', 'Breakfast Included', 'Pets Allowed', '24-Hour Front Desk'];
                            $currentAmenities = old('amenities', $hotel->amenities ?? []);
                            if (is_string($currentAmenities)) {
                                $currentAmenities = json_decode($currentAmenities, true) ?? [];
                            }
                        @endphp

                        @foreach($amenitiesList as $amenity)
                            <div class="flex items-center">
                                <input type="checkbox" id="amenity-{{ Str::slug($amenity) }}" name="amenities[]" value="{{ $amenity }}"
                                       {{ in_array($amenity, $currentAmenities) ? 'checked' : '' }}
                                       class="h-4 w-4 text-hotel-blue focus:ring-hotel-blue border-gray-300 rounded">
                                <label for="amenity-{{ Str::slug($amenity) }}" class="ml-2 text-gray-700">{{ $amenity }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-lg font-semibold text-gray-700 mb-2">
                <i class="fas fa-image text-hotel-blue mr-2"></i>
                Hotel Image
            </label>
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/default-hotel.jpg') }}" 
                         alt="Hotel Image" 
                         class="w-32 h-32 object-cover rounded-lg border-4 border-white shadow-md">
                </div>
                <div class="flex-1">
                    <input type="file" id="image" name="image" 
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-hotel-blue/10 file:text-hotel-blue
                                  hover:file:bg-hotel-blue/20">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF (Max 2MB)</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-lg font-semibold text-gray-700 mb-2">
                <i class="fas fa-map-pin text-hotel-red mr-2"></i>
                Location Coordinates
            </label>
            <p class="text-sm text-gray-500 mb-3">These help travelers find your location on the map</p>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="text" id="latitude" name="latitude" 
                           value="{{ old('latitude', $hotel->latitude ?? '') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                           placeholder="e.g. 31.6295">
                </div>
                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="text" id="longitude" name="longitude" 
                           value="{{ old('longitude', $hotel->longitude ?? '') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                           placeholder="e.g. -7.9811">
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
            <button type="button" onclick="window.location='{{ route('hotel.profile') }}'" 
                    class="mr-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300">
                Cancel
            </button>
            <button type="submit" 
                    class="bg-hotel-blue hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                <i class="fas fa-save mr-2"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('img[alt="Hotel Image"]').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

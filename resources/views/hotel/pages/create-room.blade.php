@extends('hotel.layouts.hotel')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-door-open text-hotel-blue mr-3"></i>
        Add New Room
    </h1>
    <a href="{{ route('hotel.rooms') }}" class="flex items-center text-hotel-blue hover:underline">
        <i class="fas fa-arrow-left mr-2"></i> Back to Rooms
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

    <form method="POST" action="{{ route('hotel.rooms.store') }}" class="p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-6">
                    <label for="name" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-id-card text-hotel-blue mr-2"></i>
                        Room Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                           placeholder="e.g., Deluxe King Room" required>
                </div>

                <div class="mb-6">
                    <label for="room_number" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-hashtag text-hotel-blue mr-2"></i>
                        Room Number
                    </label>
                    <input type="text" id="room_number" name="room_number" 
                           value="{{ old('room_number') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                           placeholder="e.g., 101">
                    <p class="text-sm text-gray-500 mt-1">Optional - Unique identifier for this room</p>
                </div>
                
                <div class="mb-6">
                    <label for="room_type_id" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-hotel-blue mr-2"></i>
                        Room Type <span class="text-red-500">*</span>
                    </label>
                    <select id="room_type_id" name="room_type_id" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                            required>
                        <option value="">Select Room Type</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-6">
                    <label for="capacity" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-users text-hotel-blue mr-2"></i>
                        Capacity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="capacity" name="capacity" 
                           value="{{ old('capacity') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 border"
                           min="1" placeholder="Number of guests" required>
                </div>

                <div class="mb-6">
                    <label for="price_per_night" class="block text-lg font-semibold text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign text-hotel-green mr-2"></i>
                        Price/Night <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                        <input type="number" id="price_per_night" name="price_per_night" 
                               value="{{ old('price_per_night') }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-hotel-blue focus:border-hotel-blue p-3 pl-8 border"
                               step="0.01" min="0" placeholder="0.00" required>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_available" value="1" class="rounded border-gray-300 text-hotel-blue focus:ring-hotel-blue h-5 w-5" 
                               {{ old('is_available', 1) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Available for booking</span>
                    </label>
                    <p class="text-sm text-gray-500 ml-7 mt-1">Uncheck this if the room is temporarily unavailable</p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
            <button type="button" onclick="window.location='{{ route('hotel.rooms') }}'" 
                    class="mr-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300">
                Cancel
            </button>
            <button type="submit" 
                    class="bg-hotel-green hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle mr-2"></i> Add Room
            </button>
        </div>
    </form>

    <div class="px-6 pb-6 pt-2">
        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
            <h3 class="text-lg font-semibold text-blue-800 mb-2 flex items-center">
                <i class="fas fa-info-circle mr-2"></i> Need to add a new room type?
            </h3>
            <p class="text-blue-700 mb-3">
                If you need to add a room type that's not in the list above, please contact our support team.
            </p>
            <p class="text-sm text-blue-600">
                Common room types include: Single Room, Double Room, Twin Room, Suite, Deluxe Room, etc.
            </p>
        </div>
    </div>
</div>

<script>
    // Add validation for price to ensure it has proper format
    document.getElementById('price_per_night').addEventListener('blur', function() {
        const value = parseFloat(this.value);
        if (!isNaN(value)) {
            this.value = value.toFixed(2);
        }
    });
</script>
@endsection

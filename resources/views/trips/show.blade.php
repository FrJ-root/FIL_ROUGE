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
        @php
            $coverImageUrl = null;
            if ($trip->cover_picture) {
                $coverImageUrl = asset('storage/images/trip/' . $trip->cover_picture);
            } else {
                // Fallback to destination image if cover_picture is not set
                $destinationName = explode(',', $trip->destination)[0] ?? '';
                $destination = App\Models\Destination::where('name', $destinationName)->first();
                $coverImageUrl = $destination ? getDestinationImageUrl($destination->name, $destination->location) 
                         : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
            }
        @endphp
        <div class="relative w-full h-96 md:h-[500px] overflow-hidden mb-8">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $coverImageUrl }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/50 to-black/70"></div>
            <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-12">
                <div class="container mx-auto">
                    <div class="flex flex-col md:flex-row md:items-end justify-between">
                        <div class="text-white mb-6 md:mb-0">
                            <div class="mb-2">
                                <a href="{{ route('trips.index') }}" class="text-white/80 hover:text-white transition-colors inline-flex items-center">
                                    <i class="fas fa-arrow-left mr-2"></i> Back to Trips
                                </a>
                            </div>
                            <h1 class="text-4xl md:text-5xl font-bold mb-2 drop-shadow-lg">{{ $trip->destination }}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-white/90">
                                <p><i class="far fa-calendar-alt mr-2"></i> {{ date('M d', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                                <p><i class="far fa-clock mr-2"></i> {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                                <p><i class="fas fa-users mr-2"></i> {{ $trip->travellers->count() }} travellers</p>
                            </div>
                        </div>
                        @if(isset($canEdit) && $canEdit)
                        <div class="flex gap-2">
                            <a href="{{ route('trips.edit', $trip->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8 mt-16">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Trip Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 mb-4">Trip Details</h2>
                                <p class="text-gray-600 mb-2"><i class="far fa-calendar-alt mr-2"></i> <strong>Start Date:</strong> {{ date('M d, Y', strtotime($trip->start_date)) }}</p>
                                <p class="text-gray-600 mb-2"><i class="far fa-calendar-alt mr-2"></i> <strong>End Date:</strong> {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                                <p class="text-gray-600 mb-2"><i class="far fa-clock mr-2"></i> <strong>Duration:</strong> {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</p>
                            </div>
                            @if(isset($canEdit) && $canEdit)
                            <div class="flex space-x-2">
                                <a href="{{ route('trips.edit', $trip->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition-colors">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Itinerary -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">Itinerary</h2>
                            @if(isset($canEdit) && $canEdit)
                            <button onclick="toggleItineraryForm()" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            @endif
                        </div>

                        <div id="itinerary-display">
                            <h3 class="text-xl font-bold mb-2">{{ $trip->itinerary->title ?? 'Trip to ' . $trip->destination }}</h3>
                            <p class="text-gray-700">{{ $trip->itinerary->description ?? 'No description available for this trip yet.' }}</p>
                        </div>

                        @if(isset($canEdit) && $canEdit)
                        <div id="itinerary-form" class="hidden">
                            <form action="{{ route('trips.itinerary.update', $trip->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                                    <input type="text" name="title" id="title" value="{{ $trip->itinerary->title ?? '' }}" 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                                    <textarea name="description" id="description" rows="4" 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">{{ $trip->itinerary->description ?? '' }}</textarea>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="toggleItineraryForm()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>

                    <!-- Activities -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">Activities</h2>
                            @if(isset($canEdit) && $canEdit)
                            <button onclick="toggleActivityForm()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">
                                <i class="fas fa-plus mr-1"></i> Add Activity
                            </button>
                            @endif
                        </div>

                        @if(isset($canEdit) && $canEdit)
                        <div id="activity-form" class="hidden mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-4">Add New Activity</h3>
                            <form action="{{ route('trips.activities.add', $trip->id) }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="name" class="block text-gray-700 font-bold mb-2">Activity Name</label>
                                        <input type="text" name="name" id="name" 
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    </div>
                                    <div>
                                        <label for="location" class="block text-gray-700 font-bold mb-2">Location</label>
                                        <input type="text" name="location" id="location" 
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="scheduled_at" class="block text-gray-700 font-bold mb-2">Date & Time</label>
                                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                                    <textarea name="description" id="description" rows="3" 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="toggleActivityForm()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">
                                        Add Activity
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif

                        @if(count($trip->activities) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($trip->activities->sortBy('scheduled_at') as $activity)
                            <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] bg-white">
                                @php
                                    $activityImageUrl = asset('images/activities/' . strtolower(str_replace(' ', '-', $activity->name)) . '.jpg');
                                @endphp
                                <div class="h-32 bg-gray-200 relative" style="background-image: url('{{ $activityImageUrl }}'); background-size: cover; background-position: center;">
                                    <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/70 to-transparent text-white">
                                        <span class="font-bold">{{ date('M d, Y - g:i A', strtotime($activity->scheduled_at)) }}</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-bold text-lg text-gray-800">{{ $activity->name }}</h3>
                                            <p class="text-gray-600 mb-1"><i class="fas fa-map-marker-alt mr-2"></i> {{ $activity->location }}</p>
                                            @if($activity->description)
                                            <p class="text-gray-700 mt-2 text-sm">{{ $activity->description }}</p>
                                            @endif
                                        </div>
                                        @if(isset($canEdit) && $canEdit)
                                        <form action="{{ route('trips.activities.remove', [$trip->id, $activity->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this activity?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">No activities have been added to this trip yet.</p>
                            @if(isset($canEdit) && $canEdit)
                            <button onclick="toggleActivityForm()" class="mt-2 text-blue-500 hover:text-blue-700">
                                <i class="fas fa-plus mr-1"></i> Add your first activity
                            </button>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Travellers -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Travellers</h2>
                            @if(isset($canEdit) && $canEdit)
                            <button onclick="toggleTravellerForm()" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-plus"></i> Add
                            </button>
                            @endif
                        </div>

                        @if(isset($canEdit) && $canEdit)
                        <div id="traveller-form" class="hidden mb-4 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-bold mb-2">Add Traveller</h3>
                            <form action="{{ route('trips.travellers.add', $trip->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="block text-gray-700 font-bold mb-1">Email</label>
                                    <input type="email" name="email" id="email" 
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <p class="text-xs text-gray-500 mt-1">User must have an account in the system</p>
                                </div>
                                <div class="mb-3">
                                    <label for="nationality" class="block text-gray-700 font-bold mb-1">Nationality (optional)</label>
                                    <input type="text" name="nationality" id="nationality" 
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="mb-3">
                                    <label for="passport_number" class="block text-gray-700 font-bold mb-1">Passport Number (optional)</label>
                                    <input type="text" name="passport_number" id="passport_number" 
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="toggleTravellerForm()" class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition-colors">
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif

                        @php
                            $creatorId = Auth::check() ? Auth::id() : null;
                        @endphp

                        <div class="space-y-3">
                            @if(count($trip->travellers) > 0)
                                @php
                                    $totalTravellers = $trip->travellers->count();
                                    $displayTravellers = $trip->travellers->filter(function($traveller) use ($creatorId) {
                                        return $traveller->user_id != $creatorId;
                                    });
                                @endphp
                                
                                <div class="p-3 bg-gray-50 rounded-lg mb-2">
                                    <p class="font-medium text-gray-700">
                                        <i class="fas fa-users mr-2 text-red-500"></i> 
                                        {{ $totalTravellers }} traveller{{ $totalTravellers != 1 ? 's' : '' }} on this trip
                                    </p>
                                </div>
                                
                                @foreach($displayTravellers as $traveller)
                                <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="flex items-center">
                                        <img src="{{ $traveller->user->profile_photo_url ?? asset('storage/images/default-avatar.png') }}" 
                                            alt="Avatar" class="w-10 h-10 rounded-full mr-3 object-cover border border-gray-200">
                                        <div>
                                            <div class="font-medium">{{ $traveller->user->name }}</div>
                                            @if($traveller->nationality)
                                                <div class="text-sm text-gray-500">{{ $traveller->nationality }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if(isset($canEdit) && $canEdit && count($trip->travellers) > 1 && (Auth::check() && $traveller->user_id != Auth::id()))
                                    <form action="{{ route('trips.travellers.remove', [$trip->id, $traveller->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this traveller?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endforeach

                                @if($displayTravellers->count() == 0 && $totalTravellers > 0)
                                <div class="text-center py-3 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500">You're the only traveller so far</p>
                                    <p class="text-sm text-gray-400 mt-1">Invite others to join your trip!</p>
                                </div>
                                @endif
                            @else
                            <div class="text-center py-4 bg-gray-50 rounded-lg">
                                <p class="text-gray-500">No travellers yet</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Trip Timeline -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Trip Timeline</h2>
                        
                        @if(count($trip->activities) > 0)
                        <div class="relative">
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gradient-to-b from-red-400 via-red-500 to-red-600"></div>
                            <div class="space-y-6">
                                @php $activities = $trip->activities->sortBy('scheduled_at'); @endphp
                                @foreach($activities as $activity)
                                <div class="relative pl-10 group">
                                    <div class="absolute left-0 top-1.5 w-8 flex justify-center z-10">
                                        <div class="w-4 h-4 rounded-full bg-red-500 border-2 border-white group-hover:scale-125 transition-transform"></div>
                                    </div>
                                    <div class="p-3 rounded-lg border border-gray-100 shadow-sm hover:shadow transition-all bg-white">
                                        <div class="text-sm text-gray-500 mb-1 font-medium">{{ date('M d, Y - g:i A', strtotime($activity->scheduled_at)) }}</div>
                                        <div class="font-bold text-gray-800">{{ $activity->name }}</div>
                                        <div class="text-sm text-gray-600"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $activity->location }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">No activities scheduled yet</p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Join Trip CTA (Only for non-authenticated users) -->
                    @guest
                    <div class="bg-green-50 rounded-lg shadow-md p-6 mt-6 border border-green-100">
                        <div class="text-center">
                            <i class="fas fa-users text-green-500 text-3xl mb-3"></i>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Want to join this trip?</h3>
                            <p class="text-gray-600 mb-4">Create an account or sign in to connect with fellow travelers!</p>
                            <div class="space-x-2">
                                <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                                    Login
                                </a>
                                <a href="{{ route('register') }}?redirect={{ url()->current() }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">
                                    Register
                                </a>
                            </div>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Related Trips Section -->
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Trips</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedTrips as $trip)
                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="h-36 bg-gray-200 relative">
                        @php
                            $imageUrl = null;
                            if ($trip->cover_picture) {
                                $imageUrl = asset('storage/trips/' . $trip->cover_picture);
                            } else {
                                // Fallback to destination image if cover_picture is not set
                                $destinationName = explode(',', $trip->destination)[0] ?? '';
                                $destination = App\Models\Destination::where('name', $destinationName)->first();
                                $imageUrl = $destination ? getDestinationImageUrl($destination->name, $destination->location) 
                                       : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $trip->destination }}" class="w-full h-full object-cover">
                        <img src="{{ $imageUrl }}" alt="{{ $trip->destination }}" class="w-full h-full object-cover">
                    </div>lass="p-4">
                    <div class="p-4">xt-lg font-bold text-gray-800">{{ $trip->destination }}</h3>
                        <h3 class="text-lg font-bold text-gray-800">{{ $trip->destination }}</h3>_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                        <p class="text-sm text-gray-600">{{ date('M d, Y', strtotime($trip->start_date)) }} - {{ date('M d, Y', strtotime($trip->end_date)) }}</p>
                        <a href="{{ route('trips.show', $trip->id) }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">View Trip</a>
                    </div>
                </div>reach
                @endforeach
            </div>
        </div>
    </div>n
@endsection
@push('styles')
@push('styles')
<style>Parallax-like effect for the hero image */
    /* Parallax-like effect for the hero image */
    .bg-cover {und-size: cover;
        background-size: cover;.5s ease;
        transition: transform 0.5s ease;
    }
    /* Subtle zoom effect on hover */
    /* Subtle zoom effect on hover */
    .relative:hover .bg-cover {
        transform: scale(1.05);
    }
    /* Add some motion to the page when content scrolls */
    /* Add some motion to the page when content scrolls */
    .relative {tive: 1000px;
        perspective: 1000px;
    }
    /* Enhance shadow effect on cards */
    /* Enhance shadow effect on cards */
    .shadow-md:hover {10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }le>
</style>
@endpush
@push('scripts')
@push('scripts')
<script>tion safeToggle(elementId) {
    function safeToggle(elementId) {ElementById(elementId);
        const element = document.getElementById(elementId);
        if (element) {assList.toggle('hidden');
            element.classList.toggle('hidden');
            return true;
        }eturn false;
        return false;
    }
    function toggleItineraryForm() {
    function toggleItineraryForm() {rm')) {
        if (safeToggle('itinerary-form')) {;
            safeToggle('itinerary-display');
        }
    }
    function toggleActivityForm() {
    function toggleActivityForm() {;
        safeToggle('activity-form');
    }
    function toggleTravellerForm() {
    function toggleTravellerForm() {;
        safeToggle('traveller-form');
    }ipt>
</script>@endpush
@extends('guide.layouts.guide')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Header -->
    <div class="relative bg-cover bg-center rounded-xl shadow-xl overflow-hidden mb-8" style="background-image: url('{{ asset('images/morocco-landscape.jpg') }}'); height: 300px;">
        <div class="absolute inset-0 bg-gradient-to-r from-adventure-blue/90 to-blue-800/90"></div>
        <div class="relative z-10 p-8 h-full flex flex-col justify-center">
            <h1 class="text-4xl font-bold text-white mb-2">Manage Your Availability</h1>
            <p class="text-blue-100 max-w-2xl">Set your schedule and preferred locations to connect with travelers</p>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Status Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <div>
                        <p class="font-bold">Please fix these errors:</p>
                        <ul class="list-disc pl-5 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="p-6 md:p-8">
            <form method="POST" action="{{ route('guide.updateAvailability') }}">
                @csrf
                
                <!-- Availability Toggle -->
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-user-clock text-adventure-blue mr-2"></i>
                        Your Current Status
                    </label>
                    <div class="flex flex-col sm:flex-row sm:space-x-6 space-y-3 sm:space-y-0">
                        <div class="flex-1">
                            <input type="radio" id="available" name="availability" value="available" 
                                   {{ old('availability', $guide->availability) === 'available' ? 'checked' : '' }}
                                   class="hidden peer" onclick="toggleCalendar(true)">
                            <label for="available" class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-adventure-green hover:bg-gray-50 transition-all">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center peer-checked:bg-adventure-green peer-checked:border-adventure-green">
                                        <div class="w-3 h-3 rounded-full bg-white"></div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">Available</h3>
                                        <p class="text-sm text-gray-500">Ready to accept new adventures</p>
                                    </div>
                                </div>
                                <i class="fas fa-check-circle text-xl text-adventure-green opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </label>
                        </div>
                        
                        <div class="flex-1">
                            <input type="radio" id="not_available" name="availability" value="not available" 
                                   {{ old('availability', $guide->availability) === 'not available' ? 'checked' : '' }}
                                   class="hidden peer" onclick="toggleCalendar(false)">
                            <label for="not_available" class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-400 hover:bg-gray-50 transition-all">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center peer-checked:bg-red-400 peer-checked:border-red-400">
                                        <div class="w-3 h-3 rounded-full bg-white"></div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">Not Available</h3>
                                        <p class="text-sm text-gray-500">Taking a break from guiding</p>
                                    </div>
                                </div>
                                <i class="fas fa-times-circle text-xl text-red-400 opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Calendar Section -->
                <div id="calendar-section" class="mb-8 {{ old('availability', $guide->availability) === 'available' ? '' : 'hidden' }}">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <label class="block text-lg font-semibold text-gray-800 mb-2 md:mb-0">
                            <i class="fas fa-calendar-day text-adventure-orange mr-2"></i>
                            Mark Your Available Dates
                        </label>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-adventure-green rounded mr-2"></div>
                                <span class="text-sm text-gray-600">Available</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-blue-100 border border-blue-300 rounded mr-2"></div>
                                <span class="text-sm text-gray-600">Today</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl shadow-inner">
                        <div class="flex justify-between items-center mb-4">
                            <button type="button" id="prev-month" class="text-gray-500 hover:text-adventure-blue p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <h3 id="current-month" class="text-lg font-semibold text-gray-800">June 2023</h3>
                            <button type="button" id="next-month" class="text-gray-500 hover:text-adventure-blue p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div id="calendar" class="grid grid-cols-7 gap-2">
                            <!-- Calendar headers -->
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Sun</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Mon</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Tue</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Wed</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Thu</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Fri</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Sat</div>
                            <!-- Calendar days will be inserted here by JavaScript -->
                        </div>
                    </div>
                    <input type="hidden" id="selected_dates" name="selected_dates" value="{{ old('selected_dates', $guide->selected_dates ?? '') }}">
                    <p class="mt-3 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i> Click on dates to mark them as available. You can navigate months using the arrows.
                    </p>
                </div>

                <!-- Location Preferences -->
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-map-marker-alt text-adventure-purple mr-2"></i>
                        Preferred Guiding Locations
                    </label>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-gray-600 mb-3">Select the regions where you're most comfortable guiding:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach(['Marrakech', 'Fes', 'Chefchaouen', 'Sahara Desert', 'Atlas Mountains', 'Casablanca', 'Essaouira', 'Tangier'] as $location)
                                <div class="flex items-center">
                                    <input type="checkbox" id="location-{{ Str::slug($location) }}" name="preferred_locations[]" value="{{ $location }}"
                                           {{ in_array($location, old('preferred_locations', $guide->preferred_locations ?? [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-adventure-purple focus:ring-adventure-purple border-gray-300 rounded">
                                    <label for="location-{{ Str::slug($location) }}" class="ml-2 text-gray-700">{{ $location }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="flex items-center justify-center bg-adventure-green hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Save Availability
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarContainer = document.getElementById('calendar');
        const selectedDatesInput = document.getElementById('selected_dates');
        const currentMonthElement = document.getElementById('current-month');
        const prevMonthButton = document.getElementById('prev-month');
        const nextMonthButton = document.getElementById('next-month');
        const calendarSection = document.getElementById('calendar-section');
        
        let currentDate = new Date();
        let selectedDates = new Set(selectedDatesInput.value.split(',').filter(date => date));

        function renderCalendar() {
            // Clear previous calendar days (keep headers)
            while (calendarContainer.children.length > 7) {
                calendarContainer.removeChild(calendarContainer.lastChild);
            }

            // Set month title
            currentMonthElement.textContent = new Intl.DateTimeFormat('en-US', { 
                month: 'long', 
                year: 'numeric' 
            }).format(currentDate);

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Get days in month and first day of month
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDay = new Date(year, month, 1).getDay();
            
            // Get today's date for comparison
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Normalize today's date to midnight

            // Add empty cells for days before the first day of the month
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.className = 'invisible';
                calendarContainer.appendChild(emptyCell);
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                if (date < today) {
                    // Skip past days
                    continue;
                }

                const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayElement = document.createElement('button');
                dayElement.type = 'button';
                dayElement.textContent = day;
                
                // Base classes
                dayElement.className = 'w-10 h-10 flex items-center justify-center rounded-full text-sm font-medium transition-colors';
                
                // Add selected class if date is selected
                if (selectedDates.has(formattedDate)) {
                    dayElement.classList.add('bg-adventure-green', 'text-white', 'hover:bg-green-600');
                } else {
                    dayElement.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                }
                
                // Add today class if it's today's date
                if (date.getTime() === today.getTime()) {
                    dayElement.classList.add('border-2', 'border-blue-300', 'bg-blue-50');
                }
                
                dayElement.addEventListener('click', () => toggleDateSelection(formattedDate, dayElement));
                calendarContainer.appendChild(dayElement);
            }
        }

        function toggleDateSelection(date, element) {
            if (selectedDates.has(date)) {
                selectedDates.delete(date);
                element.classList.remove('bg-adventure-green', 'text-white', 'hover:bg-green-600');
                element.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
            } else {
                selectedDates.add(date);
                element.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                element.classList.add('bg-adventure-green', 'text-white', 'hover:bg-green-600');
            }
            
            selectedDatesInput.value = Array.from(selectedDates).join(',');
        }

        function toggleCalendar(show) {
            calendarSection.classList.toggle('hidden', !show);
        }

        // Month navigation
        prevMonthButton.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        nextMonthButton.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        // Initialize calendar
        renderCalendar();
    });
</script>
@endsection
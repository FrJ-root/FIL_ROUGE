@extends('hotel.layouts.hotel')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative bg-cover bg-center rounded-xl shadow-xl overflow-hidden mb-8" style="background-image: url('{{ asset('images/hotel-room.jpg') }}'); height: 300px;">
        <div class="absolute inset-0 bg-gradient-to-r from-hotel-blue/90 to-blue-800/90"></div>
        <div class="relative z-10 p-8 h-full flex flex-col justify-center">
            <h1 class="text-4xl font-bold text-white mb-2">Manage Room Availability</h1>
            <p class="text-blue-100 max-w-2xl">Set your hotel's availability and help travelers find the perfect stay</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
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
            <form method="POST" action="{{ route('hotel.availability.update') }}">
                @csrf
                
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-hotel text-hotel-blue mr-2"></i>
                        Hotel Status
                    </label>
                    <div class="flex flex-col sm:flex-row sm:space-x-6 space-y-3 sm:space-y-0">
                        <div class="flex-1">
                            <input type="radio" id="available" name="availability" value="available" 
                                   {{ old('availability', $hotel->availability ?? '') === 'available' ? 'checked' : '' }}
                                   class="hidden peer" onclick="toggleCalendar(true)">
                            <label for="available" class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-hotel-green hover:bg-gray-50 transition-all">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center peer-checked:bg-hotel-green peer-checked:border-hotel-green">
                                        <div class="w-3 h-3 rounded-full bg-white"></div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">Available</h3>
                                        <p class="text-sm text-gray-500">Ready for bookings</p>
                                    </div>
                                </div>
                                <i class="fas fa-check-circle text-xl text-hotel-green opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </label>
                        </div>
                        
                        <div class="flex-1">
                            <input type="radio" id="not_available" name="availability" value="not available" 
                                   {{ old('availability', $hotel->availability ?? '') === 'not available' ? 'checked' : '' }}
                                   class="hidden peer" onclick="toggleCalendar(false)">
                            <label for="not_available" class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-400 hover:bg-gray-50 transition-all">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center peer-checked:bg-red-400 peer-checked:border-red-400">
                                        <div class="w-3 h-3 rounded-full bg-white"></div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">Not Available</h3>
                                        <p class="text-sm text-gray-500">No rooms available</p>
                                    </div>
                                </div>
                                <i class="fas fa-times-circle text-xl text-red-400 opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <div id="calendar-section" class="mb-8 {{ old('availability', $hotel->availability ?? '') === 'available' ? '' : 'hidden' }}">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <label class="block text-lg font-semibold text-gray-800 mb-2 md:mb-0">
                            <i class="fas fa-calendar-day text-hotel-orange mr-2"></i>
                            Mark Available Dates
                        </label>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-hotel-green rounded mr-2"></div>
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
                            <button type="button" id="prev-month" class="text-gray-500 hover:text-hotel-blue p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <h3 id="current-month" class="text-lg font-semibold text-gray-800">June 2023</h3>
                            <button type="button" id="next-month" class="text-gray-500 hover:text-hotel-blue p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div id="calendar" class="grid grid-cols-7 gap-2">
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Sun</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Mon</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Tue</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Wed</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Thu</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Fri</div>
                            <div class="text-center font-medium text-gray-500 text-sm py-2">Sat</div>
                        </div>
                    </div>
                    <input type="hidden" id="selected_dates" name="selected_dates" value="{{ old('selected_dates', $hotel->selected_dates ?? '') }}">
                    <p class="mt-3 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i> Click on dates to mark them as available.
                    </p>
                </div>

                <div id="rooms-section" class="mb-8 {{ old('availability', $hotel->availability ?? '') === 'available' ? '' : 'hidden' }}">
                    <label class="block text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-door-open text-hotel-purple mr-2"></i>
                        Available Rooms
                    </label>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-gray-600 mb-4">Specify how many rooms are available for booking:</p>
                        
                        <div class="flex items-center">
                            <button type="button" id="decrease-rooms" class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-l-lg p-2 focus:outline-none focus:ring-2 focus:ring-hotel-blue">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="available_rooms" name="available_rooms" 
                                   value="{{ old('available_rooms', $hotel->available_rooms ?? 0) }}" 
                                   class="w-16 text-center border-y border-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-hotel-blue" 
                                   min="0">
                            <button type="button" id="increase-rooms" class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-r-lg p-2 focus:outline-none focus:ring-2 focus:ring-hotel-blue">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="flex items-center justify-center bg-hotel-green hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5">
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
        const roomsSection = document.getElementById('rooms-section');
        const increaseRoomsButton = document.getElementById('increase-rooms');
        const decreaseRoomsButton = document.getElementById('decrease-rooms');
        const availableRoomsInput = document.getElementById('available_rooms');
        increaseRoomsButton.addEventListener('click', function() {
            let current = parseInt(availableRoomsInput.value) || 0;
            availableRoomsInput.value = current + 1;
        });
        
        decreaseRoomsButton.addEventListener('click', function() {
            let current = parseInt(availableRoomsInput.value) || 0;
            if (current > 0) {
                availableRoomsInput.value = current - 1;
            }
        });
        
        window.toggleCalendar = function(show) {
            if (calendarSection) calendarSection.classList.toggle('hidden', !show);
            if (roomsSection) roomsSection.classList.toggle('hidden', !show);
        };
        
        let currentDate = new Date();
        let selectedDates = new Set(selectedDatesInput.value.split(',').filter(date => date));

        function renderCalendar() {
            while (calendarContainer.children.length > 7) {
                calendarContainer.removeChild(calendarContainer.lastChild);
            }

            currentMonthElement.textContent = new Intl.DateTimeFormat('en-US', { 
                month: 'long', 
                year: 'numeric' 
            }).format(currentDate);

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDay = new Date(year, month, 1).getDay();
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.className = 'invisible';
                calendarContainer.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                if (date < today) {
                    continue;
                }

                const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayElement = document.createElement('button');
                dayElement.type = 'button';
                dayElement.textContent = day;
                
                dayElement.className = 'w-10 h-10 flex items-center justify-center rounded-full text-sm font-medium transition-colors';
                
                if (selectedDates.has(formattedDate)) {
                    dayElement.classList.add('bg-hotel-green', 'text-white', 'hover:bg-green-600');
                } else {
                    dayElement.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                }
                
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
                element.classList.remove('bg-hotel-green', 'text-white', 'hover:bg-green-600');
                element.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
            } else {
                selectedDates.add(date);
                element.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                element.classList.add('bg-hotel-green', 'text-white', 'hover:bg-green-600');
            }
            
            selectedDatesInput.value = Array.from(selectedDates).join(',');
        }

        prevMonthButton.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        nextMonthButton.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    });
</script>
@endsection

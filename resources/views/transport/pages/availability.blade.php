@extends('transport.layouts.transport')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative bg-cover bg-center rounded-xl shadow-xl overflow-hidden mb-8" style="background-image: url('{{ asset('images/transport-fleet.jpg') }}'); height: 300px;">
        <div class="absolute inset-0 bg-gradient-to-r from-transport-blue/90 to-blue-800/90"></div>
        <div class="relative z-10 p-8 h-full flex flex-col justify-center">
            <h1 class="text-4xl font-bold text-white mb-2">Manage Your Availability</h1>
            <p class="text-blue-100 max-w-2xl">Set your transport schedule to connect with travelers</p>
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
            <form method="POST" action="{{ route('transport.availability.update') }}">
                @csrf
                
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-truck text-transport-blue mr-2"></i>
                        Your Transport Status
                    </label>
                    <div class="flex flex-col sm:flex-row sm:space-x-6 space-y-3 sm:space-y-0">
                        <div class="flex-1">
                            <input type="radio" id="available" name="availability" value="available" 
                                   {{ old('availability', $transport->availability ?? '') === 'available' ? 'checked' : '' }}
                                   class="hidden peer" onclick="toggleAvailabilitySections(true)">
                            <label for="available" class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-transport-green hover:bg-gray-50 transition-all">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center peer-checked:bg-transport-green peer-checked:border-transport-green">
                                        <div class="w-3 h-3 rounded-full bg-white"></div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">Available</h3>
                                        <p class="text-sm text-gray-500">Ready to transport travelers</p>
                                    </div>
                                </div>
                                <i class="fas fa-check-circle text-xl text-transport-green opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </label>
                        </div>
                        
                        <div class="flex-1">
                            <input type="radio" id="not_available" name="availability" value="not available" 
                                   {{ old('availability', $transport->availability ?? '') === 'not available' ? 'checked' : '' }}
                                   class="hidden peer" onclick="toggleAvailabilitySections(false)">
                            <label for="not_available" class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-400 hover:bg-gray-50 transition-all">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center peer-checked:bg-red-400 peer-checked:border-red-400">
                                        <div class="w-3 h-3 rounded-full bg-white"></div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">Not Available</h3>
                                        <p class="text-sm text-gray-500">Taking a break from transport services</p>
                                    </div>
                                </div>
                                <i class="fas fa-times-circle text-xl text-red-400 opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <div id="calendar-section" class="mb-8 {{ old('availability', $transport->availability ?? '') === 'available' ? '' : 'hidden' }}">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                        <label class="block text-lg font-semibold text-gray-800 mb-2 md:mb-0">
                            <i class="fas fa-calendar-day text-transport-orange mr-2"></i>
                            Mark Your Available Dates
                        </label>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-transport-green rounded mr-2"></div>
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
                            <button type="button" id="prev-month" class="text-gray-500 hover:text-transport-blue p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <h3 id="current-month" class="text-lg font-semibold text-gray-800">June 2023</h3>
                            <button type="button" id="next-month" class="text-gray-500 hover:text-transport-blue p-2 rounded-full hover:bg-gray-100 transition-colors">
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
                    <input type="hidden" id="selected_dates" name="selected_dates" value="{{ old('selected_dates', $transport->selected_dates ?? '') }}">
                    <p class="mt-3 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i> Click on dates to mark them as available. You can navigate months using the arrows.
                    </p>
                </div>

                <div id="transport-type-section" class="mb-8 {{ old('availability', $transport->availability ?? '') === 'available' ? '' : 'hidden' }}">
                    <label class="block text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-truck text-transport-purple mr-2"></i>
                        Transport Type
                    </label>
                    <p class="text-gray-600 mb-4">Select the type of transportation you provide:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="relative">
                            <input type="radio" id="transport-tourist-vehicle" name="transport_type" value="Tourist vehicle" 
                                  {{ old('transport_type', $transport->transport_type ?? '') == 'Tourist vehicle' ? 'checked' : '' }}
                                  class="hidden peer">
                            <label for="transport-tourist-vehicle" class="flex flex-col p-4 border-2 rounded-lg cursor-pointer peer-checked:border-transport-blue peer-checked:bg-blue-50 transition-all hover:bg-gray-50">
                                <div class="flex items-center mb-2">
                                    <div class="p-2 bg-blue-100 rounded-full mr-3">
                                        <i class="fas fa-car text-blue-500"></i>
                                    </div>
                                    <span class="font-semibold">Tourist Vehicle</span>
                                </div>
                                <p class="text-sm text-gray-500">Cars, SUVs for small groups</p>
                            </label>
                            <div class="absolute top-4 right-4 h-5 w-5 bg-white border-2 border-gray-300 rounded-full peer-checked:bg-transport-blue peer-checked:border-transport-blue flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <input type="radio" id="transport-bus" name="transport_type" value="Bus" 
                                  {{ old('transport_type', $transport->transport_type ?? '') == 'Bus' ? 'checked' : '' }}
                                  class="hidden peer">
                            <label for="transport-bus" class="flex flex-col p-4 border-2 rounded-lg cursor-pointer peer-checked:border-transport-blue peer-checked:bg-blue-50 transition-all hover:bg-gray-50">
                                <div class="flex items-center mb-2">
                                    <div class="p-2 bg-green-100 rounded-full mr-3">
                                        <i class="fas fa-bus text-green-500"></i>
                                    </div>
                                    <span class="font-semibold">Bus</span>
                                </div>
                                <p class="text-sm text-gray-500">For larger groups</p>
                            </label>
                            <div class="absolute top-4 right-4 h-5 w-5 bg-white border-2 border-gray-300 rounded-full peer-checked:bg-transport-blue peer-checked:border-transport-blue flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <input type="radio" id="transport-train" name="transport_type" value="Train" 
                                  {{ old('transport_type', $transport->transport_type ?? '') == 'Train' ? 'checked' : '' }}
                                  class="hidden peer">
                            <label for="transport-train" class="flex flex-col p-4 border-2 rounded-lg cursor-pointer peer-checked:border-transport-blue peer-checked:bg-blue-50 transition-all hover:bg-gray-50">
                                <div class="flex items-center mb-2">
                                    <div class="p-2 bg-red-100 rounded-full mr-3">
                                        <i class="fas fa-train text-red-500"></i>
                                    </div>
                                    <span class="font-semibold">Train</span>
                                </div>
                                <p class="text-sm text-gray-500">Rail transportation</p>
                            </label>
                            <div class="absolute top-4 right-4 h-5 w-5 bg-white border-2 border-gray-300 rounded-full peer-checked:bg-transport-blue peer-checked:border-transport-blue flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <input type="radio" id="transport-plane" name="transport_type" value="Plane" 
                                  {{ old('transport_type', $transport->transport_type ?? '') == 'Plane' ? 'checked' : '' }}
                                  class="hidden peer">
                            <label for="transport-plane" class="flex flex-col p-4 border-2 rounded-lg cursor-pointer peer-checked:border-transport-blue peer-checked:bg-blue-50 transition-all hover:bg-gray-50">
                                <div class="flex items-center mb-2">
                                    <div class="p-2 bg-yellow-100 rounded-full mr-3">
                                        <i class="fas fa-plane text-yellow-500"></i>
                                    </div>
                                    <span class="font-semibold">Plane</span>
                                </div>
                                <p class="text-sm text-gray-500">Air transportation</p>
                            </label>
                            <div class="absolute top-4 right-4 h-5 w-5 bg-white border-2 border-gray-300 rounded-full peer-checked:bg-transport-blue peer-checked:border-transport-blue flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <input type="radio" id="transport-horse" name="transport_type" value="Horse" 
                                  {{ old('transport_type', $transport->transport_type ?? '') == 'Horse' ? 'checked' : '' }}
                                  class="hidden peer">
                            <label for="transport-horse" class="flex flex-col p-4 border-2 rounded-lg cursor-pointer peer-checked:border-transport-blue peer-checked:bg-blue-50 transition-all hover:bg-gray-50">
                                <div class="flex items-center mb-2">
                                    <div class="p-2 bg-amber-100 rounded-full mr-3">
                                        <i class="fas fa-horse text-amber-500"></i>
                                    </div>
                                    <span class="font-semibold">Horse</span>
                                </div>
                                <p class="text-sm text-gray-500">Horse riding tours</p>
                            </label>
                            <div class="absolute top-4 right-4 h-5 w-5 bg-white border-2 border-gray-300 rounded-full peer-checked:bg-transport-blue peer-checked:border-transport-blue flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <input type="radio" id="transport-camel" name="transport_type" value="Camel" 
                                  {{ old('transport_type', $transport->transport_type ?? '') == 'Camel' ? 'checked' : '' }}
                                  class="hidden peer">
                            <label for="transport-camel" class="flex flex-col p-4 border-2 rounded-lg cursor-pointer peer-checked:border-transport-blue peer-checked:bg-blue-50 transition-all hover:bg-gray-50">
                                <div class="flex items-center mb-2">
                                    <div class="p-2 bg-orange-100 rounded-full mr-3">
                                        <i class="fas fa-hiking text-orange-500"></i>
                                    </div>
                                    <span class="font-semibold">Camel</span>
                                </div>
                                <p class="text-sm text-gray-500">Desert expeditions</p>
                            </label>
                            <div class="absolute top-4 right-4 h-5 w-5 bg-white border-2 border-gray-300 rounded-full peer-checked:bg-transport-blue peer-checked:border-transport-blue flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="vehicle-capacity-section" class="mb-8 {{ old('availability', $transport->availability ?? '') === 'available' ? '' : 'hidden' }}">
                    <label class="block text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-users text-transport-blue mr-2"></i>
                        Vehicle Capacity
                    </label>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-gray-600 mb-3">Please specify your capacity based on selected transport type:</p>
                        
                        <div id="capacity-tourist-vehicle" class="capacity-options {{ old('transport_type', $transport->transport_type ?? '') == 'Tourist vehicle' ? '' : 'hidden' }}">
                            <select name="vehicle_capacity" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-transport-blue focus:border-transport-blue">
                                <option value="">Select Tourist Vehicle capacity</option>
                                <option value="1-4 seats" {{ ($transport->vehicle_capacity ?? '') == '1-4 seats' ? 'selected' : '' }}>1-4 seats (Standard Car)</option>
                                <option value="5-8 seats" {{ ($transport->vehicle_capacity ?? '') == '5-8 seats' ? 'selected' : '' }}>5-8 seats (Minivan)</option>
                                <option value="9-15 seats" {{ ($transport->vehicle_capacity ?? '') == '9-15 seats' ? 'selected' : '' }}>9-15 seats (Van)</option>
                            </select>
                        </div>
                        
                        <div id="capacity-bus" class="capacity-options {{ old('transport_type', $transport->transport_type ?? '') == 'Bus' ? '' : 'hidden' }}">
                            <select name="vehicle_capacity" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-transport-blue focus:border-transport-blue">
                                <option value="">Select Bus capacity</option>
                                <option value="16-30 seats" {{ ($transport->vehicle_capacity ?? '') == '16-30 seats' ? 'selected' : '' }}>16-30 seats (Minibus)</option>
                                <option value="31-50 seats" {{ ($transport->vehicle_capacity ?? '') == '31-50 seats' ? 'selected' : '' }}>31-50 seats (Standard Bus)</option>
                                <option value="51+ seats" {{ ($transport->vehicle_capacity ?? '') == '51+ seats' ? 'selected' : '' }}>51+ seats (Large Bus)</option>
                            </select>
                        </div>
                        
                        <div id="capacity-train" class="capacity-options {{ old('transport_type', $transport->transport_type ?? '') == 'Train' ? '' : 'hidden' }}">
                            <select name="vehicle_capacity" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-transport-blue focus:border-transport-blue">
                                <option value="">Select Train capacity</option>
                                <option value="Standard Car" {{ ($transport->vehicle_capacity ?? '') == 'Standard Car' ? 'selected' : '' }}>Standard Car (50-80 passengers)</option>
                                <option value="First Class Car" {{ ($transport->vehicle_capacity ?? '') == 'First Class Car' ? 'selected' : '' }}>First Class Car (30-40 passengers)</option>
                                <option value="Sleeping Car" {{ ($transport->vehicle_capacity ?? '') == 'Sleeping Car' ? 'selected' : '' }}>Sleeping Car (20-30 passengers)</option>
                                <option value="Full Train" {{ ($transport->vehicle_capacity ?? '') == 'Full Train' ? 'selected' : '' }}>Full Train (Multiple Cars)</option>
                            </select>
                        </div>
                        
                        <div id="capacity-plane" class="capacity-options {{ old('transport_type', $transport->transport_type ?? '') == 'Plane' ? '' : 'hidden' }}">
                            <select name="vehicle_capacity" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-transport-blue focus:border-transport-blue">
                                <option value="">Select Plane capacity</option>
                                <option value="Small Aircraft" {{ ($transport->vehicle_capacity ?? '') == 'Small Aircraft' ? 'selected' : '' }}>Small Aircraft (5-20 passengers)</option>
                                <option value="Medium Aircraft" {{ ($transport->vehicle_capacity ?? '') == 'Medium Aircraft' ? 'selected' : '' }}>Medium Aircraft (50-100 passengers)</option>
                                <option value="Large Aircraft" {{ ($transport->vehicle_capacity ?? '') == 'Large Aircraft' ? 'selected' : '' }}>Large Aircraft (100+ passengers)</option>
                            </select>
                        </div>
                        
                        <div id="capacity-horse" class="capacity-options {{ old('transport_type', $transport->transport_type ?? '') == 'Horse' ? '' : 'hidden' }}">
                            <select name="vehicle_capacity" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-transport-blue focus:border-transport-blue">
                                <option value="">Select Horse capacity</option>
                                <option value="Single Rider" {{ ($transport->vehicle_capacity ?? '') == 'Single Rider' ? 'selected' : '' }}>Single Rider</option>
                                <option value="Small Group (2-5 horses)" {{ ($transport->vehicle_capacity ?? '') == 'Small Group (2-5 horses)' ? 'selected' : '' }}>Small Group (2-5 horses)</option>
                                <option value="Large Group (6-15 horses)" {{ ($transport->vehicle_capacity ?? '') == 'Large Group (6-15 horses)' ? 'selected' : '' }}>Large Group (6-15 horses)</option>
                            </select>
                        </div>
                        
                        <div id="capacity-camel" class="capacity-options {{ old('transport_type', $transport->transport_type ?? '') == 'Camel' ? '' : 'hidden' }}">
                            <select name="vehicle_capacity" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-transport-blue focus:border-transport-blue">
                                <option value="">Select Camel capacity</option>
                                <option value="Single Rider" {{ ($transport->vehicle_capacity ?? '') == 'Single Rider' ? 'selected' : '' }}>Single Rider</option>
                                <option value="Small Caravan (2-5 camels)" {{ ($transport->vehicle_capacity ?? '') == 'Small Caravan (2-5 camels)' ? 'selected' : '' }}>Small Caravan (2-5 camels)</option>
                                <option value="Large Caravan (6-15 camels)" {{ ($transport->vehicle_capacity ?? '') == 'Large Caravan (6-15 camels)' ? 'selected' : '' }}>Large Caravan (6-15 camels)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="flex items-center justify-center bg-transport-green hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5">
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
        const transportTypeSection = document.getElementById('transport-type-section');
        const vehicleCapacitySection = document.getElementById('vehicle-capacity-section');
        const availableRadio = document.getElementById('available');
        const notAvailableRadio = document.getElementById('not_available');
        
        function initializeDisplay() {
            const isAvailable = availableRadio && availableRadio.checked;
            toggleAvailabilitySections(isAvailable);
        }
        
        window.toggleAvailabilitySections = function(show) {
            if (calendarSection) calendarSection.classList.toggle('hidden', !show);
            if (transportTypeSection) transportTypeSection.classList.toggle('hidden', !show);
            if (vehicleCapacitySection) vehicleCapacitySection.classList.toggle('hidden', !show);
        };
        
        const transportRadios = document.querySelectorAll('input[name="transport_type"]');
        const capacityOptions = document.querySelectorAll('.capacity-options');
        
        function updateCapacityOptions() {
            const selectedTransport = document.querySelector('input[name="transport_type"]:checked')?.value;
            
            capacityOptions.forEach(option => {
                option.classList.add('hidden');
            });
            
            if (selectedTransport) {
                const targetOption = document.getElementById(`capacity-${selectedTransport.toLowerCase().replace(' ', '-')}`);
                if (targetOption) {
                    targetOption.classList.remove('hidden');
                }
            }
        }
        
        transportRadios.forEach(radio => {
            radio.addEventListener('change', updateCapacityOptions);
        });
        
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
                    dayElement.classList.add('bg-transport-green', 'text-white', 'hover:bg-green-600');
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
                element.classList.remove('bg-transport-green', 'text-white', 'hover:bg-green-600');
                element.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
            } else {
                selectedDates.add(date);
                element.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                element.classList.add('bg-transport-green', 'text-white', 'hover:bg-green-600');
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
        updateCapacityOptions();
        initializeDisplay();
    });
</script>
@endsection
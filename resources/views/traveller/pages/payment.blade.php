@extends('traveller.layouts.trips')

@section('trip_content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-indigo-600 text-white flex justify-between items-center">
            <h2 class="text-xl font-semibold">Trip Payment</h2>
            <a href="{{ route('trips.show', $trip->id) }}" class="text-sm px-4 py-2 bg-white text-indigo-600 rounded-full hover:bg-indigo-50 transition-colors">
                <i class="fas fa-arrow-left mr-1"></i> Back to Trip
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-4 rounded">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-4 rounded">
            {{ session('error') }}
        </div>
        @endif

        <div class="p-6">
            <div class="flex flex-col md:flex-row md:space-x-6">
                <div class="md:w-1/2 mb-6 md:mb-0">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Trip Summary</h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex items-center mb-4">
                            <div class="h-16 w-16 rounded-md bg-cover bg-center mr-4" 
                                 style="background-image: url('{{ $trip->cover_picture ? asset('storage/images/trip/' . $trip->cover_picture) : 'https://via.placeholder.com/150' }}')">
                            </div>
                            <div>
                                <h4 class="font-medium text-indigo-600">{{ $trip->destination }}</h4>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($trip->start_date)->format('M d, Y') }} - 
                                    {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) + 1 }} days</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Trip Price:</span>
                                <span class="font-medium">$1,250.00 USD</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service Fee:</span>
                                <span class="font-medium">$75.00 USD</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-gray-200">
                                <span class="text-gray-800 font-bold">Total:</span>
                                <span class="text-indigo-600 font-bold">$1,325.00 USD</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-500">
                        <p class="mb-2"><i class="fas fa-info-circle mr-1 text-indigo-500"></i> Payment is required to confirm your booking.</p>
                        <p><i class="fas fa-shield-alt mr-1 text-indigo-500"></i> All payments are secure and encrypted.</p>
                    </div>
                </div>
                
                <div class="md:w-1/2 border-t md:border-t-0 md:border-l border-gray-200 pt-6 md:pt-0 md:pl-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Method</h3>
                    
                    <form action="{{ route('traveller.trips.process-payment', $trip->id) }}" method="POST" id="payment-form" onsubmit="return validatePaymentForm()" class="space-y-4">
                        @csrf
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center">
                                <input id="card" name="payment_method" type="radio" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="card" class="ml-2 block text-sm text-gray-700 font-medium">Credit Card</label>
                            </div>
                            <div class="flex items-center ml-5 text-sm text-gray-500">
                                <i class="fab fa-cc-visa mr-2 text-lg"></i>
                                <i class="fab fa-cc-mastercard mr-2 text-lg"></i>
                                <i class="fab fa-cc-amex mr-2 text-lg"></i>
                                <i class="fab fa-cc-discover text-lg"></i>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="card_name" class="block text-sm font-medium text-gray-700">Name on card</label>
                                <input type="text" id="card_name" name="card_name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700">Card number</label>
                                <input type="text" id="card_number" name="card_number" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="•••• •••• •••• ••••">
                            </div>
                            
                            <div class="flex space-x-4">
                                <div class="w-1/2">
                                    <label for="expiration" class="block text-sm font-medium text-gray-700">Expiration (MM/YY)</label>
                                    <input type="text" id="expiration" name="expiration" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="MM / YY">
                                </div>
                                <div class="w-1/2">
                                    <label for="cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                                    <input type="text" id="cvc" name="cvc" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="•••">
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-4 mt-6 border-t border-gray-200">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 items-center">
                                <i class="fas fa-lock mr-2"></i> Pay Securely $1,325.00
                            </button>
                        </div>
                        
                        <p class="text-xs text-center text-gray-500 mt-4">
                            By completing this payment, you agree to our <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validatePaymentForm() {
        const cardName = document.getElementById('card_name');
        const cardNumber = document.getElementById('card_number');
        const expiration = document.getElementById('expiration');
        const cvc = document.getElementById('cvc');
        
        if (!cardName.value.trim()) {
            showError(cardName, 'Cardholder name is required');
            return false;
        }
        
        if (!cardNumber.value.trim() || cardNumber.value.replace(/\s/g, '').length < 13) {
            showError(cardNumber, 'Please enter a valid card number');
            return false;
        }
        
        const expRegex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
        if (!expiration.value.trim() || !expRegex.test(expiration.value)) {
            showError(expiration, 'Please enter a valid expiration date (MM/YY)');
            return false;
        }
        
        const [month, year] = expiration.value.split('/');
        const expiryDate = new Date(2000 + parseInt(year), parseInt(month) - 1, 1);
        const today = new Date();
        
        if (expiryDate < today) {
            showError(expiration, 'This card has expired');
            return false;
        }
        
        if (!cvc.value.trim() || !/^[0-9]{3,4}$/.test(cvc.value)) {
            showError(cvc, 'Please enter a valid security code (CVC/CVV)');
            return false;
        }
        
        return true;
    }
    
    function showError(inputElement, message) {
        const existingError = inputElement.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-500 text-sm mt-1';
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
        
        inputElement.parentNode.appendChild(errorDiv);
        
        inputElement.classList.add('border-red-500');
        
        inputElement.focus();
        
        return false;
    }
    
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = '';
        
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formattedValue += ' ';
            }
            formattedValue += value[i];
        }
        
        e.target.value = formattedValue;
    });
    
    document.getElementById('expiration').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 2) {
            e.target.value = value.slice(0, 2) + '/' + value.slice(2, 4);
        } else {
            e.target.value = value;
        }
    });
</script>
@endsection
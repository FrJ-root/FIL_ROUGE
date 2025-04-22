@extends('traveller.layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                <h1 class="text-2xl font-bold">Complete Your Booking</h1>
                <p class="mt-2 text-blue-100">Payment required to confirm your trip to {{ $trip->destination }}</p>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between p-4 mb-6 bg-blue-50 rounded-lg">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">{{ $trip->destination }}</h2>
                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($trip->start_date)->format('M d, Y') }} - 
                            {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-blue-600">$599.00</p>
                        <p class="text-sm text-gray-500">Total Amount</p>
                    </div>
                </div>
                
                <form action="{{ route('traveller.trips.process-payment', $trip->id) }}" method="POST">
                    @csrf
                    
                    @if($errors->any())
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                            <div class="font-bold">Please correct the following errors:</div>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Details</h3>
                        
                        <div class="mb-4">
                            <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                            <input type="text" id="card_number" name="card_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="1234 5678 9012 3456" maxlength="16" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-1">Card Holder Name</label>
                            <input type="text" id="card_holder" name="card_holder" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="John Doe" required>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                <input type="text" id="expiry_date" name="expiry_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="MM/YY" required>
                            </div>
                            <div>
                                <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                <input type="text" id="cvv" name="cvv" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="123" maxlength="3" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6 flex items-center justify-between">
                        <a href="{{ route('traveller.trips') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                            <i class="fas fa-arrow-left mr-1"></i> Cancel and go back
                        </a>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Pay $599.00 and Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Secure Payment</h3>
                <p class="text-gray-600">Your payment information is encrypted and secure. We never store your full credit card details.</p>
                
                <div class="mt-4 flex space-x-4">
                    <div class="h-8 w-12 bg-gray-200 rounded"></div>
                    <div class="h-8 w-12 bg-gray-200 rounded"></div>
                    <div class="h-8 w-12 bg-gray-200 rounded"></div>
                    <div class="h-8 w-12 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

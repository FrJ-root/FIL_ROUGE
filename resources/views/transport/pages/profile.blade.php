@extends('transport.layouts.transport')

@section('content')
<div class="mb-8">
    <div class="relative bg-cover bg-center rounded-xl shadow-xl overflow-hidden" style="background-image: url('{{ asset('images/transport-bg.jpg') }}'); height: 300px;">
        <div class="absolute inset-0 bg-gradient-to-r from-transport-blue/90 to-blue-800/90"></div>
        <div class="relative z-10 p-8 h-full flex flex-col justify-end">
            <h1 class="text-4xl font-bold text-white mb-2">Company Profile</h1>
            <p class="text-blue-100 max-w-2xl">Manage your transport company details</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
    <div class="p-6">
        <div class="flex flex-col md:flex-row items-start gap-8">
            <div class="w-full md:w-1/3 flex flex-col items-center">
                <div class="rounded-full overflow-hidden border-4 border-transport-blue w-48 h-48 mb-4">
                    <img src="{{ Auth::user()->picture ? asset('storage/'.Auth::user()->picture) : asset('images/default-profile.png') }}" 
                         alt="Profile Picture" class="w-full h-full object-cover">
                </div>
                <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500">{{ $transport->company_name ?? 'Company Name Not Set' }}</p>
                <span class="mt-3 bg-transport-blue text-white px-4 py-1 rounded-full text-sm">
                    {{ ucfirst($transport->transport_type ?? 'Transport Provider') }}
                </span>
            </div>
            
            <div class="w-full md:w-2/3 mt-6 md:mt-0">
                <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-200">
                    <i class="fas fa-info-circle text-transport-blue mr-2"></i>
                    Company Details
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-500">License Number</div>
                        <div class="font-medium">{{ $transport->license_number ?? 'Not provided' }}</div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-500">Transport Type</div>
                        <div class="font-medium">{{ $transport->transport_type ?? 'Not specified' }}</div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-500">Phone</div>
                        <div class="font-medium">{{ $transport->phone ?? 'Not provided' }}</div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-500">Email</div>
                        <div class="font-medium">{{ Auth::user()->email ?? 'Not provided' }}</div>
                    </div>
                </div>
                
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">Address</div>
                    <div class="font-medium">{{ $transport->address ?? 'Not provided' }}</div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('transport.profile.edit') }}" class="bg-transport-blue hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        <i class="fas fa-edit mr-2"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

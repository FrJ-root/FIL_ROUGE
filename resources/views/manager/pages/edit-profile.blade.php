@extends('manager.layouts.manager')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-user-edit text-manager-primary mr-3"></i>
        Edit Profile
    </h1>
    <a href="{{ route('manager.profile') }}" class="text-gray-600 hover:text-manager-primary flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back to Profile
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <p>{{ session('success') }}</p>
    </div>
</div>
@endif

@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <div>
            <p class="font-bold">Please fix the following errors:</p>
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-manager-primary to-purple-600 text-white p-6">
        <h2 class="text-xl font-bold">Update Your Profile Information</h2>
        <p class="text-purple-200 mt-1">Edit your personal details and profile picture</p>
    </div>
    
    <form method="POST" action="{{ route('manager.profile.update') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-manager-primary focus:border-manager-primary">
                </div>
                
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-manager-primary focus:border-manager-primary">
                </div>
            </div>
            
            <div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Profile Picture</label>
                    <div class="flex items-center">
                        <div class="mr-4">
                            @if(Auth::user()->picture)
                                <img src="{{ asset('storage/' . Auth::user()->picture) }}" alt="Current Profile Picture"
                                    class="w-24 h-24 rounded-full object-cover border-4 border-gray-200" id="picture-preview">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-4xl font-bold border-4 border-gray-200" id="picture-preview-placeholder">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <img src="" alt="Profile Preview" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 hidden" id="picture-preview">
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="picture" id="picture" 
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-manager-primary hover:file:bg-violet-100">
                            <p class="mt-1 text-sm text-gray-500">Upload a new profile picture (JPEG, PNG, GIF)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('manager.profile') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                Cancel
            </a>
            <button type="submit" class="bg-manager-primary hover:bg-purple-700 text-white font-bold py-2 px-6 rounded shadow-md transform transition-transform hover:scale-105">
                <i class="fas fa-save mr-2"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('picture').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('picture-preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                
                const placeholder = document.getElementById('picture-preview-placeholder');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

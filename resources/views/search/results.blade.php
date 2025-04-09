@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 pt-24">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Search Results for "{{ $query }}"</h1>
        
        @if(count($results) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($results as $result)
                    {{-- Display search results here --}}
                @endforeach
            </div>
        @else
            <div class="bg-white shadow-md rounded-lg p-8 text-center">
                <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">No results found</h2>
                <p class="text-gray-600">We couldn't find any destinations matching "{{ $query }}".</p>
                <p class="mt-4 text-gray-500">Try different keywords or check out our popular destinations below.</p>
            </div>
            
            <div class="mt-12">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Popular Destinations</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    {{-- Add popular destinations here --}}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

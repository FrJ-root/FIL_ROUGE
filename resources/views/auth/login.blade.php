@extends('layouts.app')

@section('content')
<section class="relative bg-gray-50 py-20 min-h-screen flex items-center">
    <div class="absolute inset-0 overflow-hidden opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3')] bg-cover bg-center"></div>
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex justify-center">
            <div class="w-full lg:w-1/2">
                @include('components.auth.login-form')
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    body {
        background-color: #f9fafb;
    }
</style>
@endpush
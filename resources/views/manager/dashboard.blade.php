@extends('manager.layouts.manager')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-manager-primary to-purple-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="mt-2 opacity-90">Manage your trips and collaborations with ease</p>
            </div>
            <div class="bg-white/20 p-4 rounded-full">
                <i class="fas fa-briefcase text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
@endsection

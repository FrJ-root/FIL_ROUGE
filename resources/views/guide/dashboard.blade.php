@extends('guide.layouts.guide')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-adventure-blue to-blue-600 text-white p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="mt-2 opacity-90">Ready for your next adventure?</p>
            </div>
            <div class="bg-white/20 p-4 rounded-full">
                <i class="fas fa-mountain text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
    <i class="fas fa-tachometer-alt mr-2 text-adventure-blue"></i>
    Quick Actions
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('guide.profile') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-adventure-blue/10 text-adventure-blue p-4 rounded-lg mr-4 group-hover:bg-adventure-blue group-hover:text-white transition-colors duration-300">
                <i class="fas fa-user-edit text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-adventure-blue transition-colors duration-300">View Profile</h3>
                <p class="text-gray-600 text-sm mt-1">Update your professional details</p>
            </div>
        </div>
    </a>

    <a href="{{ route('guide.availability') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-adventure-green/10 text-adventure-green p-4 rounded-lg mr-4 group-hover:bg-adventure-green group-hover:text-white transition-colors duration-300">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-adventure-green transition-colors duration-300">Availability</h3>
                <p class="text-gray-600 text-sm mt-1">Set your guiding schedule</p>
            </div>
        </div>
    </a>

    <a href="{{ route('guide.travellers') }}" class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl group">
        <div class="p-6 flex items-start">
            <div class="bg-adventure-orange/10 text-adventure-orange p-4 rounded-lg mr-4 group-hover:bg-adventure-orange group-hover:text-white transition-colors duration-300">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800 group-hover:text-adventure-orange transition-colors duration-300">Travellers</h3>
                <p class="text-gray-600 text-sm mt-1">Manage your current trips</p>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-adventure-blue text-white px-6 py-4 flex items-center">
            <i class="fas fa-route mr-2"></i>
            <h3 class="font-bold">Upcoming Guided Trips</h3>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-center py-8">
                <div class="text-center">
                    <i class="fas fa-compass text-4xl text-gray-300 mb-4"></i>
                    <h4 class="text-gray-500">No upcoming trips scheduled</h4>
                    <p class="text-sm text-gray-400 mt-1">When you have trips, they'll appear here</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-adventure-green text-white px-6 py-4 flex items-center">
            <i class="fas fa-comments mr-2"></i>
            <h3 class="font-bold">Recent Messages</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="bg-blue-100 text-adventure-blue p-3 rounded-full mr-4">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold">Ahmed R.</h4>
                        <p class="text-gray-600 text-sm">Interested in your Sahara tour...</p>
                        <p class="text-xs text-gray-400 mt-1">2 days ago</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-green-100 text-adventure-green p-3 rounded-full mr-4">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold">Sophie M.</h4>
                        <p class="text-gray-600 text-sm">Can you guide us in Chefchaouen...</p>
                        <p class="text-xs text-gray-400 mt-1">5 days ago</p>
                    </div>
                </div>
            </div>
            <a href="#" class="block text-center mt-6 text-adventure-blue font-semibold hover:underline">
                View all messages
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.grid a, .grid > div');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `all 0.5s ease ${index * 0.1}s`;
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    });
</script>
@endsection
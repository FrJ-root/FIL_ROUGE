@extends('layouts.app')

@section('content')
<div class="pt-24">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <div class="flex items-center text-gray-500 text-sm mb-6">
            <a href="{{ route('home') }}" class="hover:text-green-500">Home</a>
            <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
            <a href="{{ route('travel-guides') }}" class="hover:text-green-500">Travel Guides</a>
            <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
            <span class="text-gray-800">{{ $guide->title ?? 'Paris Travel Guide' }}</span>
        </div>

        <!-- Guide Header -->
        <div class="relative rounded-xl overflow-hidden mb-8 h-80 md:h-96">
            <img src="{{ $guide->image ?? asset('assets/images/placeholder.jpg') }}" alt="{{ $guide->title ?? 'Paris' }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-8">
                <span class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-bold inline-block mb-3">
                    {{ $guide->category->name ?? 'Adventure' }}
                </span>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $guide->title ?? 'Paris: The Complete Travel Guide' }}</h1>
                <div class="flex items-center text-white space-x-4">
                    <span><i class="far fa-calendar-alt mr-1"></i> {{ $guide->created_at ?? now()->format('M d, Y') }}</span>
                    <span><i class="far fa-eye mr-1"></i> {{ $guide->views ?? '1,245' }} views</span>
                    <span><i class="far fa-clock mr-1"></i> {{ $guide->read_time ?? '10 min' }} read</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-xl shadow-md p-6 md:p-10">
                    <!-- Author Info -->
                    <div class="flex items-center mb-8">
                        <img src="{{ $guide->author->avatar ?? asset('assets/images/avatar.jpg') }}" alt="Author" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $guide->author->name ?? 'Travel Expert' }}</h3>
                            <p class="text-gray-500 text-sm">Travel Writer & Photographer</p>
                        </div>
                    </div>

                    <!-- Table of Contents -->
                    <div class="bg-gray-50 rounded-lg p-5 mb-8">
                        <h3 class="font-bold text-gray-800 mb-3">Table of Contents</h3>
                        <ul class="space-y-1">
                            <li><a href="#introduction" class="text-blue-600 hover:underline">Introduction</a></li>
                            <li><a href="#best-time-to-visit" class="text-blue-600 hover:underline">Best Time to Visit</a></li>
                            <li><a href="#getting-around" class="text-blue-600 hover:underline">Getting Around</a></li>
                            <li><a href="#top-attractions" class="text-blue-600 hover:underline">Top Attractions</a></li>
                            <li><a href="#where-to-stay" class="text-blue-600 hover:underline">Where to Stay</a></li>
                            <li><a href="#local-cuisine" class="text-blue-600 hover:underline">Local Cuisine</a></li>
                        </ul>
                    </div>

                    <!-- Guide Content -->
                    <div class="prose lg:prose-lg max-w-none">
                        <h2 id="introduction">Introduction</h2>
                        <p>{{ $guide->content ?? 'Paris, the capital of France, is renowned for its rich cultural heritage, iconic landmarks, and vibrant atmosphere. With its elegant boulevards, grand museums, and charming cafés, Paris offers a unique blend of history, art, and gastronomy that captivates visitors from around the world.' }}</p>
                        
                        <p>Whether you're gazing at the Eiffel Tower, admiring masterpieces at the Louvre, strolling along the Seine, or savoring a croissant at a sidewalk café, Paris promises an unforgettable experience for travelers of all interests.</p>
                        
                        <h2 id="best-time-to-visit">Best Time to Visit</h2>
                        <p>The ideal time to visit Paris is during spring (April to June) or fall (September to November), when the weather is pleasant and the city is less crowded. Summer (July and August) brings warm temperatures but also peak tourism season, while winter offers festive holiday decorations and fewer visitors.</p>
                        
                        <h2 id="getting-around">Getting Around</h2>
                        <p>Paris boasts an extensive public transportation system, making it easy to navigate the city:</p>
                        <ul>
                            <li>Metro: With 16 lines covering the entire city, the Paris Metro is fast, efficient, and comprehensive.</li>
                            <li>Bus: Paris has over 300 bus routes, offering scenic views of the city during your journey.</li>
                            <li>RER: This regional train network connects central Paris with suburbs and major attractions like Disneyland Paris.</li>
                            <li>Vélib': The city's bike-sharing program provides an eco-friendly way to explore.</li>
                        </ul>
                        
                        <h2 id="top-attractions">Top Attractions</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
                            <div class="rounded-lg overflow-hidden">
                                <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Eiffel Tower" class="w-full h-48 object-cover">
                            </div>
                            <div class="rounded-lg overflow-hidden">
                                <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Louvre Museum" class="w-full h-48 object-cover">
                            </div>
                        </div>
                        <p>Paris is home to numerous world-famous attractions:</p>
                        <ul>
                            <li><strong>Eiffel Tower:</strong> The iconic symbol of Paris offers breathtaking views of the city.</li>
                            <li><strong>Louvre Museum:</strong> Housing masterpieces like the Mona Lisa, the Louvre is the world's largest art museum.</li>
                            <li><strong>Notre-Dame Cathedral:</strong> A masterpiece of Gothic architecture (currently being restored after the 2019 fire).</li>
                            <li><strong>Montmartre and Sacré-Cœur:</strong> This bohemian neighborhood features the stunning white-domed basilica and spectacular city views.</li>
                            <li><strong>Champs-Élysées and Arc de Triomphe:</strong> Stroll down this famous avenue to the Arc de Triomphe.</li>
                        </ul>
                        
                        <h2 id="where-to-stay">Where to Stay</h2>
                        <p>Paris is divided into 20 arrondissements (districts), each with its own character:</p>
                        <ul>
                            <li><strong>1st-4th Arrondissements:</strong> The historic center, ideal for first-time visitors who want to be near major attractions.</li>
                            <li><strong>5th-6th Arrondissements:</strong> The Latin Quarter and Saint-Germain-des-Prés offer a blend of student life, literary history, and cafés.</li>
                            <li><strong>Montmartre (18th):</strong> A bohemian atmosphere with artistic heritage.</li>
                            <li><strong>Le Marais (3rd-4th):</strong> Trendy neighborhood with boutique shops, art galleries, and vibrant nightlife.</li>
                        </ul>
                        
                        <h2 id="local-cuisine">Local Cuisine</h2>
                        <p>No visit to Paris is complete without sampling its culinary delights:</p>
                        <ul>
                            <li><strong>Croissants and Pastries:</strong> Start your day with freshly baked goods from local boulangeries.</li>
                            <li><strong>French Cheese:</strong> Try a variety of artisanal cheeses at local fromageries.</li>
                            <li><strong>Steak-Frites:</strong> This classic dish combines perfectly cooked steak with crispy fries.</li>
                            <li><strong>Crêpes:</strong> Sweet or savory, these thin pancakes are a popular street food.</li>
                            <li><strong>Macarons:</strong> These colorful, delicate cookies are a French specialty.</li>
                        </ul>
                    </div>
                    
                    <!-- Share Links -->
                    <div class="border-t border-gray-200 pt-6 mt-8">
                        <h3 class="font-bold text-gray-800 mb-3">Share this guide</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700">
                                <i class="fab fa-facebook-f w-5 h-5 flex items-center justify-center"></i>
                            </a>
                            <a href="#" class="bg-blue-400 text-white p-2 rounded-full hover:bg-blue-500">
                                <i class="fab fa-twitter w-5 h-5 flex items-center justify-center"></i>
                            </a>
                            <a href="#" class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700">
                                <i class="fab fa-pinterest w-5 h-5 flex items-center justify-center"></i>
                            </a>
                            <a href="#" class="bg-green-500 text-white p-2 rounded-full hover:bg-green-600">
                                <i class="fab fa-whatsapp w-5 h-5 flex items-center justify-center"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white rounded-xl shadow-md p-6 md:p-10 mt-8">
                    <h3 class="text-xl font-bold mb-6">Comments (12)</h3>
                    
                    @auth
                        <div class="mb-8">
                            <form action="#" method="POST">
                                <textarea name="comment" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Share your thoughts or questions..."></textarea>
                                <div class="mt-2 text-right">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-300">Post Comment</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg mb-8">
                            <p class="text-gray-700">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to leave a comment.</p>
                        </div>
                    @endauth
                    
                    <!-- Sample Comments -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-center mb-2">
                                <img src="{{ asset('assets/images/avatar.jpg') }}" alt="Commenter" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <h4 class="font-bold text-gray-800">Sarah Johnson</h4>
                                    <p class="text-gray-500 text-sm">2 days ago</p>
                                </div>
                            </div>
                            <p class="text-gray-700">This guide was incredibly helpful for planning my trip to Paris! The restaurant recommendations were spot on. I especially loved the hidden gems section.</p>
                            <div class="mt-2 flex items-center text-gray-500 text-sm">
                                <button class="hover:text-blue-600 mr-4"><i class="far fa-thumbs-up mr-1"></i> 24</button>
                                <button class="hover:text-blue-600"><i class="far fa-reply mr-1"></i> Reply</button>
                            </div>
                        </div>
                        
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-center mb-2">
                                <img src="{{ asset('assets/images/avatar.jpg') }}" alt="Commenter" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <h4 class="font-bold text-gray-800">Michael Chen</h4>
                                    <p class="text-gray-500 text-sm">5 days ago</p>
                                </div>
                            </div>
                            <p class="text-gray-700">Could you recommend the best time to visit the Louvre to avoid crowds? I'm planning a trip for next month and want to make the most of my time there.</p>
                            <div class="mt-2 flex items-center text-gray-500 text-sm">
                                <button class="hover:text-blue-600 mr-4"><i class="far fa-thumbs-up mr-1"></i> 12</button>
                                <button class="hover:text-blue-600"><i class="far fa-reply mr-1"></i> Reply</button>
                            </div>
                            
                            <!-- Reply -->
                            <div class="ml-12 mt-4 bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <img src="{{ asset('assets/images/avatar.jpg') }}" alt="Author" class="w-8 h-8 rounded-full mr-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800">Travel Expert <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded ml-2">Author</span></h4>
                                        <p class="text-gray-500 text-sm">4 days ago</p>
                                    </div>
                                </div>
                                <p class="text-gray-700">Hi Michael! The best times to visit the Louvre are Wednesday and Friday evenings when it's open late (until 9:45 pm) and significantly less crowded. If you can't make evenings work, try going first thing in the morning and head directly to the most popular exhibits before they get busy.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <button class="text-green-600 hover:text-green-700 font-bold">Load More Comments</button>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <!-- Author Info Box -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4">About the Author</h3>
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('assets/images/avatar.jpg') }}" alt="Author" class="w-20 h-20 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $guide->author->name ?? 'Travel Expert' }}</h4>
                            <p class="text-gray-600 text-sm">Travel Writer & Photographer</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">Professional travel writer with over 10 years of experience exploring the world's most fascinating destinations. Specializes in cultural immersion and off-the-beaten-path adventures.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-500 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-500 hover:text-blue-600"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-500 hover:text-blue-600"><i class="fas fa-globe"></i></a>
                    </div>
                </div>
                
                <!-- Map -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4">Destination Map</h3>
                    <div class="h-64 bg-gray-200 rounded-lg mb-3">
                        <!-- Replace with actual map implementation -->
                        <div class="w-full h-full flex items-center justify-center text-gray-500">
                            <span>Interactive Map</span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Explore the location and key attractions in {{ $guide->destination->name ?? 'Paris' }}.</p>
                </div>
                
                <!-- Related Guides -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4">Related Guides</h3>
                    <div class="space-y-4">
                        @forelse($relatedGuides ?? [] as $relatedGuide)
                            <a href="{{ route('travel-guides.show', $relatedGuide->slug) }}" class="block group">
                                <div class="flex items-center">
                                    <img src="{{ $relatedGuide->image ?? asset('assets/images/placeholder.jpg') }}" alt="{{ $relatedGuide->title }}" class="w-20 h-20 object-cover rounded-lg mr-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 group-hover:text-red-500">{{ $relatedGuide->title }}</h4>
                                        <p class="text-gray-500 text-sm">{{ $relatedGuide->destination->name }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <a href="#" class="block group">
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Related Guide" class="w-20 h-20 object-cover rounded-lg mr-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 group-hover:text-red-500">London Weekend Guide</h4>
                                        <p class="text-gray-500 text-sm">London, UK</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block group">
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Related Guide" class="w-20 h-20 object-cover rounded-lg mr-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 group-hover:text-red-500">Rome in 3 Days</h4>
                                        <p class="text-gray-500 text-sm">Rome, Italy</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block group">
                                <div class="flex items-center">
                                    <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Related Guide" class="w-20 h-20 object-cover rounded-lg mr-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 group-hover:text-red-500">Barcelona Food Tour</h4>
                                        <p class="text-gray-500 text-sm">Barcelona, Spain</p>
                                    </div>
                                </div>
                            </a>
                        @endforelse
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-md p-6 text-white">
                    <h3 class="font-bold mb-4">Subscribe to Our Newsletter</h3>
                    <p class="mb-4 text-green-100">Get travel inspiration, tips and exclusive offers sent straight to your inbox.</p>
                    <form action="#" method="POST">
                        <input type="email" class="w-full px-4 py-2 rounded-lg text-gray-800 mb-3" placeholder="Your email address">
                        <button type="submit" class="w-full bg-white text-green-600 px-4 py-2 rounded-lg font-bold hover:bg-gray-100 transition-colors duration-300">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

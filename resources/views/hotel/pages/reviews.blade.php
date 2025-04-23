@extends('hotel.layouts.hotel')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-star text-hotel-orange mr-3"></i>
        Hotel Reviews
    </h1>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="p-6">
        <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Ratings Overview</h3>
                    @php
                        $averageRating = isset($reviews) && $reviews->count() > 0 
                            ? round($reviews->avg('rating'), 1) 
                            : 0;
                        $reviewCount = isset($reviews) ? $reviews->count() : 0;
                    @endphp
                    <div class="flex items-center">
                        <div class="bg-hotel-green text-white text-2xl font-bold rounded-lg p-3 mr-4 min-w-[60px] text-center">
                            {{ number_format($averageRating, 1) }}
                        </div>
                        <div>
                            <div class="flex text-yellow-400 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $averageRating)
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $averageRating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-gray-600">Based on {{ $reviewCount }} reviews</p>
                        </div>
                    </div>
                </div>
                
                @if($reviewCount > 0)
                <div class="flex flex-col">
                    @php
                        $ratingCounts = [
                            5 => isset($reviews) ? $reviews->where('rating', 5)->count() : 0,
                            4 => isset($reviews) ? $reviews->where('rating', 4)->count() : 0,
                            3 => isset($reviews) ? $reviews->where('rating', 3)->count() : 0,
                            2 => isset($reviews) ? $reviews->where('rating', 2)->count() : 0,
                            1 => isset($reviews) ? $reviews->where('rating', 1)->count() : 0,
                        ];
                    @endphp
                    
                    @foreach($ratingCounts as $rating => $count)
                        <div class="flex items-center mb-1">
                            <span class="text-xs text-gray-600 w-3">{{ $rating }}</span>
                            <div class="flex items-center ml-2">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                            </div>
                            <div class="w-48 h-2 mx-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="bg-hotel-blue h-full rounded-full" style="width: {{ $reviewCount > 0 ? ($count / $reviewCount) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-xs text-gray-600">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        @if(isset($reviews) && $reviews->count() > 0)
            <h3 class="text-xl font-bold text-gray-800 mb-4">Guest Reviews</h3>
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                        <div class="flex justify-between items-start">
                            <div class="flex items-start">
                                <div class="bg-gray-100 rounded-full h-12 w-12 flex items-center justify-center font-bold text-hotel-blue mr-4">
                                    {{ strtoupper(substr($review->traveller->user->name ?? 'Guest', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $review->traveller->user->name ?? 'Guest' }}</h4>
                                    <div class="flex text-yellow-400 my-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas {{ $i <= $review->rating ? 'fa-star' : 'fa-star text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $review->created_at->format('F d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-gray-700">
                            {{ $review->comment }}
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="far fa-star text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-600 mb-2">No Reviews Yet</h3>
                <p class="text-gray-500 max-w-md mx-auto">When guests leave reviews for your hotel, they'll appear here. Great service leads to excellent reviews!</p>
            </div>
        @endif
    </div>
</div>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
        font-weight: 500;
    }
    
    .pagination li {
        margin: 0 3px;
    }
    
    .pagination li a,
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 8px;
        background: white;
        color: #374151;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .pagination li a:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
    }
    
    .pagination li.active span {
        background: #1976D2;
        color: white;
        border-color: #1976D2;
    }
    
    .pagination li.disabled span {
        color: #9ca3af;
        pointer-events: none;
    }
</style>
@endsection

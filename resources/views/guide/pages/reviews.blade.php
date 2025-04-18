@extends('guide.layouts.guide')

@section('content')
<h1 class="text-2xl font-bold mb-6">Guide Reviews</h1>
<div class="bg-white shadow rounded-xl p-6">
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($reviews->isEmpty())
        <p class="text-gray-600">No reviews yet.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach ($reviews as $review)
                <li class="py-4">
                    <div class="flex items-center mb-2">
                        <div class="bg-blue-500 text-white rounded-full h-10 w-10 flex items-center justify-center font-bold mr-4">
                            {{ strtoupper(substr($review->traveller->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-semibold">{{ $review->traveller->user->name }}</h4>
                            <div class="text-yellow-500">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @for ($i = $review->rating; $i < 5; $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">{{ $review->comment }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

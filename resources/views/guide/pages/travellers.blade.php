@extends('guide.layouts.guide')

@section('content')
<h1 class="text-2xl font-bold mb-6">Travellers</h1>
<div class="bg-white shadow rounded-xl p-6">
    @if ($travellers->isEmpty())
        <p class="text-gray-600">No travellers found for your trips.</p>
    @else
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="py-2 px-4 font-medium text-gray-600">Name</th>
                    <th class="py-2 px-4 font-medium text-gray-600">Email</th>
                    <th class="py-2 px-4 font-medium text-gray-600">Trip Destination</th>
                    <th class="py-2 px-4 font-medium text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($travellers as $traveller)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $traveller->user->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4">{{ $traveller->user->email ?? 'N/A' }}</td>
                        <td class="py-2 px-4">{{ $traveller->trip->destination ?? 'N/A' }}</td>
                        <td class="py-2 px-4">
                            <button 
                                onclick="openMessageModal({{ $traveller->user->id ?? 'null' }}, '{{ addslashes($traveller->user->name ?? '') }}')" 
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Message
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
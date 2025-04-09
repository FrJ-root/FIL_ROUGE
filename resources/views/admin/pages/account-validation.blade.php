@extends('admin.layouts.admin-layout')

@section('title', 'Account Validation')

@section('content')
<div class="space-y-4">
    <h2 class="text-purple-600 font-semibold mb-4">Account Validation</h2>
    @if (session('success'))
        <div id="statusMsg"
            class="transition-opacity duration-500 bg-{{ session('status_color', 'gray') }}-600 text-white px-4 py-2 rounded fixed top-4 right-4 z-50 shadow-lg">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('statusMsg');
                if (msg) {
                    msg.classList.add('opacity-0');
                    setTimeout(() => msg.remove(), 500);
                }
            }, 1500);
        </script>
    @endif

    @foreach (['travellers', 'transportCompanies', 'hotels', 'guides'] as $role)
        <div id="{{ ucfirst($role) }}Accounts" class="bg-gray-800 p-6 rounded-lg">
            <h3 class="text-white font-semibold mb-4">{{ ucfirst($role) }} Accounts</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-900">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-400">Id</th>
                            <th class="px-4 py-2 text-left text-gray-400">Name</th>
                            <th class="px-4 py-2 text-left text-gray-400">Status</th>
                            <th class="px-4 py-2 text-left text-gray-400">Created</th>
                            <th class="px-4 py-2 text-left text-gray-400">Updated</th>
                            <th class="px-4 py-2 text-left text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($$role as $user)
                            <tr>
                                <td class="px-4 py-2 text-white">{{ $user->id }}</td>
                                <td class="px-4 py-2 text-white">{{ $user->name ?? $user->company_name ?? ($user->email ?? '-') }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        @if($user->status === 'valide') bg-green-600 text-white
                                        @elseif($user->status === 'suspend') bg-yellow-500 text-black
                                        @elseif($user->status === 'block') bg-red-600 text-white
                                        @else bg-gray-600 text-white @endif">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-white">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 text-white">{{ $user->updated_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 text-white">
                                <form action="{{ route('admin.account-validation.update', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="bg-gray-700 text-white rounded px-2 py-1">
                                        <option value="valide" {{ $user->status === 'valide' ? 'selected' : '' }}>Valide</option>
                                        <option value="suspend" {{ $user->status === 'suspend' ? 'selected' : '' }}>Suspend</option>
                                        <option value="block" {{ $user->status === 'block' ? 'selected' : '' }}>Block</option>
                                    </select>
                                </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-white text-center">No {{ $role }} accounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    @if (session('error'))
        <div class="bg-red-600 text-white px-4 py-2 mt-4 rounded">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection
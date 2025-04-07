@extends('admin.layouts.admin-layout')

@section('title', 'Account Validation')

@section('content')
    <div class="space-y-4">
        <h2 class="text-purple-600 font-semibold mb-4">Account Validation</h2>
        
        <div id="TravellersAccounts" class="bg-gray-800 p-6 rounded-lg">
            <h3 class="text-white font-semibold mb-4">Travellers Accounts</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-900">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-400">Id</th>
                            <th class="px-4 py-2 text-left text-gray-400">Name</th>
                            <th class="px-4 py-2 text-left text-gray-400">Passport number</th>
                            <th class="px-4 py-2 text-left text-gray-400">Nationality</th>
                            <th class="px-4 py-2 text-left text-gray-400">Status</th>
                            <th class="px-4 py-2 text-left text-gray-400">Created</th>
                            <th class="px-4 py-2 text-left text-gray-400">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div id="TransportAccounts" class="bg-gray-800 p-6 rounded-lg">
            <h3 class="text-white font-semibold mb-4">Transport Companies Accounts</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-900">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-400">Id</th>
                            <th class="px-4 py-2 text-left text-gray-400">Name</th>
                            <th class="px-4 py-2 text-left text-gray-400">Type</th>
                            <th class="px-4 py-2 text-left text-gray-400">Status</th>
                            <th class="px-4 py-2 text-left text-gray-400">Created</th>
                            <th class="px-4 py-2 text-left text-gray-400">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="HotelsAccounts" class="bg-gray-800 p-6 rounded-lg">
            <h3 class="text-white font-semibold mb-4">Hotels Accounts</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-900">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-400">Id</th>
                            <th class="px-4 py-2 text-left text-gray-400">Name</th>
                            <th class="px-4 py-2 text-left text-gray-400">location</th>
                            <th class="px-4 py-2 text-left text-gray-400">Phone Number</th>
                            <th class="px-4 py-2 text-left text-gray-400">Status</th>
                            <th class="px-4 py-2 text-left text-gray-400">Created</th>
                            <th class="px-4 py-2 text-left text-gray-400">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="GuidesAccounts" class="bg-gray-800 p-6 rounded-lg">
            <h3 class="text-white font-semibold mb-4">Guides Accounts</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-900">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-400">Id</th>
                            <th class="px-4 py-2 text-left text-gray-400">Name</th>
                            <th class="px-4 py-2 text-left text-gray-400">License</th>
                            <th class="px-4 py-2 text-left text-gray-400">Specialization</th>
                            <th class="px-4 py-2 text-left text-gray-400">Status</th>
                            <th class="px-4 py-2 text-left text-gray-400">Created</th>
                            <th class="px-4 py-2 text-left text-gray-400">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form[action="./acounts/updateStatus.php"]').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endsection
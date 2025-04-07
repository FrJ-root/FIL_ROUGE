@extends('admin.layouts.admin-layout')

@section('title', 'Category Management')

@section('content')
    <div id="Category-Management" class="bg-gray-800 rounded-lg p-6 border border-purple-500/10">
        <div class="flex items-center justify-between mb-6">
            <div class="text-white font-semibold">Category Management</div>
            <div class="bg-purple-500/10 rounded-full p-2">
                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
        </div>

        <form id="Add&Updatecategory" method="post">
            <div class="flex gap-4 mb-6">
                <input type="hidden" id="categoryId" name="categoryId" value="">
                <input id="categoryInput" type="text" name="addcategory" placeholder="Enter category name..."
                       class="flex-1 bg-gray-900 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                <button type="submit" id="categoryButton"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span id="buttonText">Add</span>
                </button>
                <button type="button" id="cancelButton" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md hidden">
                    Cancel
                </button>
            </div>
        </form>

        <div id="categories-list" class="flex flex-wrap gap-2">
            <!-- Categories will be populated here -->
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryInput = document.getElementById('categoryInput');
        const categoryIdInput = document.getElementById('categoryId');
        const buttonText = document.getElementById('buttonText');
        const cancelButton = document.getElementById('cancelButton');
    
        function populateFormForUpdate(categoryId, categoryTitle) {
            categoryIdInput.value = categoryId;
            categoryInput.value = categoryTitle;
            buttonText.textContent = 'Update';
            cancelButton.classList.remove('hidden');
        }
    
        function resetFormForAdd() {
            categoryIdInput.value = '';
            categoryInput.value = '';
            buttonText.textContent = 'Add';
            cancelButton.classList.add('hidden');
        }
    
        document.querySelectorAll('.update-category').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const categoryId = this.getAttribute('data-id');
                const categoryTitle = this.getAttribute('data-title');
                populateFormForUpdate(categoryId, categoryTitle);
            });
        });
    
        cancelButton.addEventListener('click', function () {
            resetFormForAdd();
        });
    });
</script>
@endsection

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

        @if(session('success'))
            <div class="bg-green-500/20 text-green-400 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/20 text-red-400 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form id="categoryForm" class="mb-6">
            @csrf
            <div class="flex gap-4">
                <input type="hidden" id="categoryId" name="categoryId" value="">
                <input id="categoryInput" type="text" name="name" placeholder="Enter category name..."
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

        <div id="categories-list" class="space-y-2">
            @foreach($categories as $category)
                <div id="category-{{ $category->id }}" class="flex items-center justify-between bg-gray-900 p-3 rounded-md">
                    <div class="flex items-center gap-2">
                        <div class="bg-purple-500/20 rounded-full p-1">
                            <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <span class="text-white">{{ $category->name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="edit-category text-blue-400 hover:text-blue-300" data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button class="delete-category text-red-400 hover:text-red-300" data-id="{{ $category->id }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryForm = document.getElementById('categoryForm');
        const categoryInput = document.getElementById('categoryInput');
        const categoryIdInput = document.getElementById('categoryId');
        const buttonText = document.getElementById('buttonText');
        const cancelButton = document.getElementById('cancelButton');
        
        function resetForm() {
            categoryIdInput.value = '';
            categoryInput.value = '';
            buttonText.textContent = 'Add';
            cancelButton.classList.add('hidden');
        }
        
        document.querySelectorAll('.edit-category').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                const categoryName = this.getAttribute('data-name');
                
                categoryIdInput.value = categoryId;
                categoryInput.value = categoryName;
                buttonText.textContent = 'Update';
                cancelButton.classList.remove('hidden');
            });
        });
        
        cancelButton.addEventListener('click', function() {
            resetForm();
        });
        
        categoryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(categoryForm);
            const categoryId = categoryIdInput.value;
            const isUpdate = categoryId !== '';
            
            const url = isUpdate 
                ? `/admin/categories/${categoryId}` 
                : '/admin/categories';
                
            const method = isUpdate ? 'PUT' : 'POST';
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: categoryInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    if (isUpdate) {
                        const categoryElement = document.querySelector(`#category-${categoryId} span`);
                        if (categoryElement) {
                            categoryElement.textContent = data.category.name;
                        }
                    } else {
                        const categoriesList = document.getElementById('categories-list');
                        const newCategory = `
                            <div id="category-${data.category.id}" class="flex items-center justify-between bg-gray-900 p-3 rounded-md">
                                <div class="flex items-center gap-2">
                                    <div class="bg-purple-500/20 rounded-full p-1">
                                        <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <span class="text-white">${data.category.name}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button class="edit-category text-blue-400 hover:text-blue-300" data-id="${data.category.id}" data-name="${data.category.name}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button class="delete-category text-red-400 hover:text-red-300" data-id="${data.category.id}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `;
                        categoriesList.insertAdjacentHTML('afterbegin', newCategory);
                        
                        const newEditButton = document.querySelector(`#category-${data.category.id} .edit-category`);
                        newEditButton.addEventListener('click', function() {
                            categoryIdInput.value = data.category.id;
                            categoryInput.value = data.category.name;
                            buttonText.textContent = 'Update';
                            cancelButton.classList.remove('hidden');
                        });
                        
                        const newDeleteButton = document.querySelector(`#category-${data.category.id} .delete-category`);
                        newDeleteButton.addEventListener('click', function() {
                            deleteCategory(data.category.id);
                        });
                    }
                    
                    resetForm();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
        
        function deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category?')) {
                fetch(`/admin/categories/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        const categoryElement = document.getElementById(`category-${categoryId}`);
                        if (categoryElement) {
                            categoryElement.remove();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the category.');
                });
            }
        }
        
        document.querySelectorAll('.delete-category').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                deleteCategory(categoryId);
            });
        });
    });
</script>
@endsection

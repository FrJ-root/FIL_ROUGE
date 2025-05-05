@extends('admin.layouts.admin-layout')

@section('title', 'Tag Management')

@section('content')
    <div id="Tag-Management" class="bg-gray-800 rounded-lg p-6 border border-purple-500/10">
        <div class="flex items-center justify-between mb-6">
            <div class="text-white font-semibold">Tag Management</div>
            <div class="bg-purple-500/10 rounded-full p-2">
                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
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
        
        <form id="tagForm" class="mb-6">
            @csrf
            <div class="flex gap-4">
                <input type="hidden" id="tagId" name="tagId" value="">
                <input id="tagInput" type="text" name="name" placeholder="Enter tag name..."
                       class="flex-1 bg-gray-900 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                <button type="submit" id="tagButton" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span id="tagButtonText">Add</span>
                </button>
                <button type="button" id="tagCancelButton" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md hidden">
                    Cancel
                </button>
            </div>
        </form>

        <div id="tags-list" class="flex flex-wrap gap-2">
            @foreach($tags as $tag)
                <div id="tag-{{ $tag->id }}" class="bg-gray-900 rounded-full px-3 py-1 inline-flex items-center justify-between">
                    <span class="text-white mr-2">{{ $tag->name }}</span>
                    <div class="flex items-center">
                        <button class="edit-tag text-blue-400 hover:text-blue-300 mr-1" data-id="{{ $tag->id }}" data-name="{{ $tag->name }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button class="delete-tag text-red-400 hover:text-red-300" data-id="{{ $tag->id }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
        const tagForm = document.getElementById('tagForm');
        const tagInput = document.getElementById('tagInput');
        const tagIdInput = document.getElementById('tagId');
        const buttonText = document.getElementById('tagButtonText');
        const cancelButton = document.getElementById('tagCancelButton');
        
        function resetForm() {
            tagIdInput.value = '';
            tagInput.value = '';
            buttonText.textContent = 'Add';
            cancelButton.classList.add('hidden');
        }
        
        document.querySelectorAll('.edit-tag').forEach(button => {
            button.addEventListener('click', function() {
                const tagId = this.getAttribute('data-id');
                const tagName = this.getAttribute('data-name');
                
                tagIdInput.value = tagId;
                tagInput.value = tagName;
                buttonText.textContent = 'Update';
                cancelButton.classList.remove('hidden');
            });
        });
        
        cancelButton.addEventListener('click', function() {
            resetForm();
        });
        
        tagForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(tagForm);
            const tagId = tagIdInput.value;
            const isUpdate = tagId !== '';
            
            const url = isUpdate 
                ? `/admin/tags/${tagId}` 
                : '/admin/tags';
                
            const method = isUpdate ? 'PUT' : 'POST';
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: tagInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    if (isUpdate) {
                        const tagElement = document.querySelector(`#tag-${tagId} span`);
                        if (tagElement) {
                            tagElement.textContent = data.tag.name;
                        }
                    } else {
                        const tagsList = document.getElementById('tags-list');
                        const newTag = `
                            <div id="tag-${data.tag.id}" class="bg-gray-900 rounded-full px-3 py-1 inline-flex items-center justify-between">
                                <span class="text-white mr-2">${data.tag.name}</span>
                                <div class="flex items-center">
                                    <button class="edit-tag text-blue-400 hover:text-blue-300 mr-1" data-id="${data.tag.id}" data-name="${data.tag.name}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button class="delete-tag text-red-400 hover:text-red-300" data-id="${data.tag.id}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `;
                        tagsList.insertAdjacentHTML('beforeend', newTag);
                        
                        const newEditButton = document.querySelector(`#tag-${data.tag.id} .edit-tag`);
                        newEditButton.addEventListener('click', function() {
                            tagIdInput.value = data.tag.id;
                            tagInput.value = data.tag.name;
                            buttonText.textContent = 'Update';
                            cancelButton.classList.remove('hidden');
                        });
                        
                        const newDeleteButton = document.querySelector(`#tag-${data.tag.id} .delete-tag`);
                        newDeleteButton.addEventListener('click', function() {
                            deleteTag(data.tag.id);
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
        
        function deleteTag(tagId) {
            if (confirm('Are you sure you want to delete this tag?')) {
                fetch(`/admin/tags/${tagId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        const tagElement = document.getElementById(`tag-${tagId}`);
                        if (tagElement) {
                            tagElement.remove();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the tag.');
                });
            }
        }
        
        document.querySelectorAll('.delete-tag').forEach(button => {
            button.addEventListener('click', function() {
                const tagId = this.getAttribute('data-id');
                deleteTag(tagId);
            });
        });
    });
</script>
@endsection

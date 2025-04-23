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
        
        <form id="Add&Updatetags" method="post">
            <div class="flex gap-4 mb-6">
                <input type="hidden" id="tagId" name="tagId" value="">
                <input id="tagInput" type="text" name="addtag" placeholder="Enter tag name..."
                       class="flex-1 bg-gray-900 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                <button type="submit" id="tagButton" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md flex items-center gap-2">
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

        <div id="tags-list" class="flex flex-wrap gap-2"></div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tagInput = document.getElementById('tagInput');
        const tagIdInput = document.getElementById('tagId');
        const buttonText = document.getElementById('tagButtonText');
        const cancelButton = document.getElementById('tagCancelButton');
    
        function populateFormForUpdate(tagId, tagTitle) {
            tagIdInput.value = tagId;
            tagInput.value = tagTitle;
            buttonText.textContent = 'Update';
            cancelButton.classList.remove('hidden');
        }
    
        function resetFormForAdd() {
            tagIdInput.value = '';
            tagInput.value = '';
            buttonText.textContent = 'Add';
            cancelButton.classList.add('hidden');
        }
    
        document.querySelectorAll('.update-tag').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const tagId = this.getAttribute('data-id');
                const tagTitle = this.getAttribute('data-title');
                populateFormForUpdate(tagId, tagTitle);
            });
        });
    
        cancelButton.addEventListener('click', function () {
            resetFormForAdd();
        });
    });
</script>
@endsection

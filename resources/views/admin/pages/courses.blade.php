@extends('admin.layouts.admin-layout')

@section('title', 'Course Management')

@section('content')
    <form id="CoursesFiltering" method="GET" action="" class="mb-8">
        <div id="SearchFiltering" class="flex flex-col md:flex-row gap-4 mb-6">
            <input type="text" 
                   name="search" 
                   placeholder="Search courses..." 
                   value=""
                   class="flex-1 bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
            
            <select name="category" 
                    class="bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                <option value="">All Categories</option>
                <!-- Categories will be populated here -->
            </select>

            <select name="tag" 
                    class="bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                <option value="">All Tags</option>
                <!-- Tags will be populated here -->
            </select>
    
            <select name="filter" 
                    class="bg-gray-800 text-white px-4 py-2 rounded-md border border-gray-700 focus:border-purple-500 focus:outline-none">
                <option value="">Sort By</option>
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
            </select>
    
            <button type="submit" 
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md flex items-center justify-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Search
            </button>
        </div>
    </form>

    <div id="Allcourses" class="space-y-4">
        <div id="CategoryCounter" class="flex justify-between items-center mb-6"></div>

        <h2 class="text-green-800 font-semibold mb-4">Active Courses</h2>
        <div id="active-courses" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Active courses will be populated here -->
        </div>

        <div id="DeletedCourses" class="space-y-4 mt-8">
            <h2 class="text-red-800 font-semibold mb-4">Deleted Courses</h2>
            <div id="deleted-courses" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Deleted courses will be populated here -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-course').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const courseId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this course?')) {
                    fetch(`../courses/deleteCourse.php?id=${courseId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                this.closest('.course-card').remove();
                            } else {
                                alert(data.message);
                            }
                        }).catch(error => console.error('Error:', error));
                }
            });
        });

        document.querySelectorAll('.restore-course').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const courseId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to restore this course?')) {
                    fetch(`../courses/restoreCourse.php?id=${courseId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                alert(data.message);
                            }
                        }).catch(error => console.error('Error:', error));
                }
            });
        });
    });
</script>
@endsection

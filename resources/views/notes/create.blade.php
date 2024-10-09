<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-900">
                    <form method="POST" action="{{ route('notes.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300" for="title">
                                {{ __('Title') }}
                            </label>
                            <input type="text" name="title" id="title" class="w-full px-4 py-2 border rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300" for="content">
                                {{ __('Content') }}
                            </label>
                            <textarea name="content" id="editor" class="w-full px-4 py-2 border rounded-md" required></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            {{ __('Create Note') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include CKEditor from CDN -->
    <script src="https://cdn.ckeditor.com/4.22.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content'); // Replace the textarea with CKEditor
    </script>
</x-app-layout>

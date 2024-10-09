<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-900">
                    <form id="noteForm" method="POST" action="{{ route('notes.update', $note->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300" for="title">
                                {{ __('Title') }}
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $note->title) }}" class="w-full px-4 py-2 border rounded-md @error('title') border-red-500 @enderror">
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300" for="content">
                                {{ __('Content') }}
                            </label>
                            <textarea name="content" id="content" class="w-full px-4 py-2 border rounded-md @error('content') border-red-500 @enderror">{{ old('content', $note->content) }}</textarea>
                            @error('content')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300" for="tags">
                                {{ __('Tags') }}
                            </label>
                            <input type="text" name="tags" id="tags" value="{{ old('tags', $note->tags) }}" class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="flex items-center space-x-4">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-300">
        {{ __('Update Note') }}
    </button>
    
    <a href="{{ route('notes.edit', $note->id) }}" class="flex items-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
        <img width="20" height="20" src="https://img.icons8.com/ios/50/available-updates.png" alt="available-updates" class="mr-2" />
        Reload
    </a>
    
    <a href="{{ route('notes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-600 transition duration-300">
        {{ __('Back to Notes') }}
    </a>
</div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="notification" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md hidden">
        Note updated successfully!
    </div>

    <script src="https://cdn.ckeditor.com/4.22.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content'); // Initialize CKEditor on the textarea

        // Display notification when the form is submitted and updated successfully
        document.getElementById('noteForm').addEventListener('submit', function(event) {
            // Display notification immediately upon submission
            const notification = document.getElementById('notification');
            notification.classList.remove('hidden');
            notification.classList.add('block');
            
            // Allow form to submit normally for backend processing
        });
    </script>
</x-app-layout>

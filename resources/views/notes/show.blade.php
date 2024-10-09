<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Note Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-bold text-xl mb-4">{{ $note->title }}</h3>
                    <div class="mb-4">
                    <p>{{ Str::limit(strip_tags($note->content), 50, '...') }}</p>

                    </div>
                    
                    <div class="flex justify-between">
                       <!-- Only show Edit option if the user owns the note -->
                            <a href="{{ route('notes.edit', $note) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                                {{ __('Edit Note') }}
                            </a>

                        <button onclick="shareNote('{{ $note->id }}')" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            {{ __('Share Note') }}
                        </button>

                        <!-- Save as New button -->
                        <form action="{{ route('notes.saveAsNew', $note->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                {{ __('Save As New Note') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function shareNote(noteId) {
            const shareUrl = window.location.origin + '/notes/' + noteId + '/edit'; // Create a view-only URL
            navigator.clipboard.writeText(shareUrl)
                .then(() => {
                    alert('Note link copied to clipboard: ' + shareUrl);
                })
                .catch(err => {
                    alert('Failed to copy: ' + err);
                });
        }
    </script>
</x-app-layout>

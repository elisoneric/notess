<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ __('My Notes') }}</h3>

                @if($notes->isEmpty())
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __('No notes available. Create your first note!') }}
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($notes as $note)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    <h3 class="font-bold text-lg">{{ $note->title }}</h3>
                                    <p>{{ Str::limit(strip_tags($note->content), 100) }}</p>
                                    <div class="mt-4">
                                        <a href="{{ route('notes.show', $note->id) }}" class="text-blue-500 hover:text-blue-700">
                                            {{ __('View |') }}
                                        </a>
                                        <a href="#" onclick="shareNote('{{ $note->id }}', '{{ route('notes.share', $note->id) }}')" class="text-green-600 hover:text-green-900 ml-4">
                                            {{ __('Share') }}
                                        </a>
                                        <a href="{{ route('notes.edit', $note->id) }}" class="text-blue-600 hover:text-blue-900 ml-4">
                                            {{ __('| Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('notes.destroy', $note->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Shared Notes Section -->
            @if (!empty($sharedNotes) && $sharedNotes->isNotEmpty())
                <h3 class="mt-8 text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('Shared with Me') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @foreach ($sharedNotes as $sharedNote)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="font-bold text-lg">{{ $sharedNote->title }}</h3>
                                <p>{{ Str::limit(strip_tags($sharedNote->content), 100) }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('notes.show', $sharedNote->id) }}" class="text-blue-500 hover:text-blue-700">
                                        {{ __('View') }}
                                    </a>
                                    <a href="#" onclick="shareNote('{{ $sharedNote->id }}', '{{ route('notes.share', $sharedNote->id) }}')" class="text-green-600 hover:text-green-900 ml-4">
                                        {{ __('Share') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Opened Notes Section -->
            @if (!empty(session('opened_notes', [])))
                <h3 class="mt-8 text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('Opened Notes') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @foreach (session('opened_notes', []) as $openedNote)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="font-bold text-lg">{{ $openedNote['title'] }}</h3>
                                <p>{{ Str::limit(strip_tags($openedNote['content']), 100) }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('notes.show', $openedNote['id']) }}" class="text-blue-500 hover:text-blue-700">
                                        {{ __('View') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('notes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                    {{ __('Create New Note') }}
                </a>
            </div>
        </div>
        <div id="custom-alert" class="custom-alert hidden">
    <span id="alert-message"></span>
</div>

    </div>
    <style>
    .custom-alert {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4caf50; /* Green background */
    color: white; /* White text */
    padding: 15px 20px;
    border-radius: 5px;
    z-index: 1000;
    transition: top 0.5s ease;
}

.hidden {
    top: -100px; /* Hide the alert above the viewport */
}

.visible {
    top: 20px; /* Show the alert */
}

</style>

<script>
    function customAlert(message) {
        const alertBox = document.getElementById('custom-alert');
        const messageSpan = document.getElementById('alert-message');

        messageSpan.textContent = message;
        alertBox.classList.remove('hidden');
        alertBox.classList.add('visible');

        // Automatically hide the alert after 3 seconds
        setTimeout(function() {
            alertBox.classList.remove('visible');
            alertBox.classList.add('hidden');
        }, 3000);
    }
</script>
    <script>
        function shareNote(noteId, shareLink) {
            // Copy the share link to clipboard
            navigator.clipboard.writeText(shareLink).then(function() {
                customAlert('Note shared! The link has been copied to your clipboard.');
            }, function() {
                customeAlert('Failed to copy the link. Please try again.');
            });
        }
    </script>
</x-app-layout>

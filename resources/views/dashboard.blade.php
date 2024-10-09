<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Create New Note Button -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('notes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Create New Note') }}
                </a>
            </div>

            <!-- Search Bar -->
            <div class="mb-4">
                <form method="GET" action="{{ route('notes.index') }}">
                    <input type="text" name="search" placeholder="{{ __('Search notes...') }}" class="border rounded-md py-2 px-4 w-full">
                </form>
            </div>

            <!-- User's Own Notes Section -->
            <div class="mb-8">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ __('My Notes') }}</h3>

                @if($userNotes->isEmpty())
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __('No notes available. Create a new note to get started!') }}
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($userNotes as $note)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    <h3 class="font-bold text-lg">{{ $note->title }}</h3>
                                    <p>{{ Str::limit(strip_tags($note->content), 100) }}</p> <!-- Strip HTML tags and limit the preview -->
                                    <div class="mt-4">
                                        <a href="{{ route('notes.show', $note) }}" class="text-blue-500 hover:text-blue-700">
                                            {{ __('View Note') }}
                                        </a>
                                        <a href="{{ route('notes.edit', $note) }}" class="text-yellow-500 hover:text-yellow-700 ml-4">
                                            {{ __('| Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('notes.destroy', $note) }}" class="inline ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" >
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                        <a href="#" onclick="shareNote('{{ $note->id }}', '{{ route('notes.edit', $note->id) }}')" class="text-green-600 hover:text-green-900 ml-4">
                                            {{ __('Share') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div id="custom-alert" class="custom-alert hidden">
    <span id="alert-message"></span>
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

            </div>

            <!-- Opened Notes (Shared or Other User's Notes) Section -->
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mt-6">{{ __('Opened Notes') }}</h3>
            @if(empty($openedNotes))
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __('No opened notes available.') }}
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($openedNotes as $note)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="font-bold text-lg">{{ $note['title'] }}</h3>
                                <p>{{ Str::limit(strip_tags($note['content']), 100) }}</p>
                                <span class="text-sm text-gray-500">{{ __('Owner: ') }}{{ $note['owner'] }}</span>
                                <div class="mt-4">
                                    <a href="{{ route('notes.show', $note['id']) }}" class="text-blue-500 hover:text-blue-700">
                                        {{ __('View Note') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    

<script>
    function shareNote(noteId, shareLink) {
        // Copy the share link to clipboard
        navigator.clipboard.writeText(shareLink).then(function() {
            customAlert('Note shared! The link has been copied to your clipboard.');
        }, function() {
            customAlert('Failed to copy the link. Please try again.');
        });
    }
</script>

</x-app-layout>

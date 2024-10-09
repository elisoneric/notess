<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    // Update the specified note in storage
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        // Find the note by ID
        $note = Note::findOrFail($id);

        // Ensure that the user owns the note before updating it
        if ($note->user_id !== Auth::id()) {
            return redirect()->route('notes.index')->with('error', 'Unauthorized action.');
        }

        // Update the note's content
        $note->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'tags' => $validated['tags'],
        ]);

        // Redirect back to the edit page with success message
        return redirect()->route('notes.edit', $note->id)->with('success', 'Note updated successfully!');
    }

    // Display a listing of all notes
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->get();
        $userNotes = Note::where('user_id', Auth::id())->get(); // User's own notes
        $allNotes = Note::where('user_id', '!=', Auth::id())->get(); // All notes from others

        // Retrieve notes opened by the user (shared section)
        $sharedNotes = Note::where('shared_with_user_id', Auth::id())->get();

        return view('notes.index', compact('notes','userNotes', 'allNotes', 'sharedNotes'));
    }

    // Show the form for creating a new note
    public function create()
    {
        return view('notes.create');
    }

    // Store a newly created note in storage
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        Note::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'tags' => $request->tags,
        ]);

        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }

    // Show the form for editing the specified note
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    // Display the dashboard
    public function dashboard()
    {
        $userNotes = Note::where('user_id', Auth::id())->get();
        $openedNotes = session('opened_notes', []);

        return view('dashboard', compact('userNotes', 'openedNotes'));
    }

    // Show the note
    public function show($id)
    {
        $note = Note::findOrFail($id);

        // If the note does not belong to the user, add it to the "opened notes" session
        if ($note->user_id !== Auth::id()) {
            $this->addToOpenedNotes($note);
        }

        return view('notes.show', compact('note'));
    }

    // Delete the note
    public function destroy(Note $note)
    {
        // Ensure the user is the owner of the note before deleting it
        if ($note->user_id !== Auth::id()) {
            return redirect()->route('notes.index')->with('error', 'Unauthorized action.');
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }

    // Save a note as a new one
    public function saveAsNew($id)
    {
        $originalNote = Note::findOrFail($id);

        // Create a new note with the same content for the logged-in user
        $newNote = Note::create([
            'title' => $originalNote->title,
            'content' => $originalNote->content,
            'tags' => $originalNote->tags,
            'user_id' => Auth::id(), 
        ]);

        return redirect()->route('notes.edit', $newNote->id)->with('success', 'Note saved as new!');
    }

    // Share a note with another user via email
    public function share(Note $note, Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Allow the user to view the note by saving to the session
            $this->addToOpenedNotes($note);
            return redirect()->back()->with('success', 'Note shared successfully!');
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    // Add a note to the session for opened/shared notes
    protected function addToOpenedNotes(Note $note)
    {
        $openedNotes = session('opened_notes', []);

        if (!array_key_exists($note->id, $openedNotes)) {
            $openedNotes[$note->id] = [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'tags' => $note->tags,
                'owner' => $note->user->name,
            ];

            session(['opened_notes' => $openedNotes]);
        }
    }
}

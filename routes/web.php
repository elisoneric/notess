<?php

use App\Models\Note;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home page route
Route::get('/', function () {
    return view('welcome');
});

// Route to display the dashboard with the authenticated user's notes and opened notes
Route::get('/dashboard', [NoteController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

// Resourceful routes for managing notes (index, create, store, edit, update)
Route::middleware(['auth'])->group(function () {
    Route::resource('notes', NoteController::class);

    // Route to save a note as a new note (copy functionality)
    Route::post('/notes/{note}/save-as-new', [NoteController::class, 'saveAsNew'])->name('notes.saveAsNew');
    Route::get('notes/share/{note}', [NoteController::class, 'share'])->name('notes.share');

    // Route to handle note sharing
    Route::post('/notes/{note}/share', [NoteController::class, 'share'])->name('notes.share');

    // Route for viewing a shared note via a token (view only, not editable)
    Route::get('/notes/shared/{token}', [NoteController::class, 'show'])->name('notes.shared');
});

// Profile routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';

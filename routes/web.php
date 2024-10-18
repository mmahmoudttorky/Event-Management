<?php

// use App\Http\Controllers\EventController;
    
// Route::middleware('auth')->group(function() {
//     Route::get('/events/create', [EventController::class, 'create']);
//     Route::post('/events', [EventController::class, 'store']);
// });

// Route::get('/events', [EventController::class, 'index']);

use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;

// Public routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    Route::get('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    // Route to view tickets for an event
    Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('tickets.index');

    // Organizer routes for ticket management
    Route::get('/events/{eventId}/tickets/manage', [TicketController::class, 'manage'])->name('tickets.manage');
    Route::delete('/tickets/{ticketId}', [TicketController::class, 'destroy'])->name('tickets.destroy');


});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

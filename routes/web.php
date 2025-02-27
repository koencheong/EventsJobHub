<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PartTimerProfileController;

// Dashboard Route (Authenticated Users)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Role-Based Redirect Route
    Route::get('/redirect', function () {
        $user = Auth::user();

        if ($user->role === 'employer') {
            return redirect()->route('dashboard'); // Employer Dashboard
        } elseif ($user->role === 'part_timer') {
            return redirect()->route('part-timers.dashboard'); // Part-Timer Dashboard
        } else {
            return redirect()->route('home'); // Fallback Home
        }
    })->name('redirect');
});

// Home Route (Dynamic Events for Part-Timers)
Route::get('/', [EventController::class, 'showEventsForPartTimers'])->name('home');

// Event Routes
Route::resource('events', EventController::class);
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Employer Home
Route::get('/employer-home', function () {
    return view('employer-home');
})->name('employer-home');

// Part-Timer Dashboard (With Auth Middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/part-timers/dashboard', [JobApplicationController::class, 'partTimerDashboard'])->name('part-timers.dashboard');

    // Job Applications
    Route::post('/apply/{event}', [JobApplicationController::class, 'applyForJob'])->name('apply');
    Route::get('/dashboard/applications', [JobApplicationController::class, 'viewApplications'])->name('dashboard.applications');
    Route::delete('/applications/{id}/cancel', [JobApplicationController::class, 'cancel'])->name('applications.cancel');
});

// Default Fallback (If User Tries /home)
Route::get('/home', function () {
    return redirect()->route('redirect');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/part-timers/profile/edit', [PartTimerProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/part-timers/profile/{id}', [PartTimerProfileController::class, 'show'])->name('public-profile.show');
    Route::post('/part-timers/profile/update', [PartTimerProfileController::class, 'update'])->name('profile.update');
});

Route::get('/check-application/{eventId}', [JobApplicationController::class, 'checkApplication']);

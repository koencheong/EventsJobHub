<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('events', EventController::class);

Route::get('/redirect', function () {
    $user = Auth::user();

    if ($user->role === 'employer') {
        return redirect()->route('employer-home');
    } else {
        return redirect()->route('home');
    }
});

Route::get('/employer-home', function () {
    return view('employer-home');
})->name('employer-home');

Route::get('/home', [EventController::class, 'showEventsForPartTimers'])->name('home');

?>
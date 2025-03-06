<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PartTimerProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use Chatify\Http\Controllers\MessagesController;
use App\Http\Controllers\RatingController;

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
    
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Admin Panel
        } elseif ($user->role === 'employer') {
            return redirect()->route('dashboard'); // Employer Dashboard
        } elseif ($user->role === 'part_timer') {
            return redirect()->route('part-timers.dashboard'); // Part-Timer Dashboard
        } else {
            return redirect('/'); // Default fallback (or change this)
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

Route::middleware(['auth'])->group(function () {
    Route::get('/part-timers/profile/edit', [PartTimerProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/part-timers/profile/{id}', [PartTimerProfileController::class, 'show'])->name('public-profile.show');
    Route::post('/part-timers/profile/update', [PartTimerProfileController::class, 'update'])->name('profile.update');
});

Route::get('/check-application/{eventId}', [JobApplicationController::class, 'checkApplication']);

Route::get('/employer/jobs', [JobApplicationController::class, 'listJobs'])
    ->middleware(['auth'])
    ->name('employer.jobs');

Route::get('/employer/jobs/{job}/applications', [JobApplicationController::class, 'viewApplications'])
    ->middleware(['auth'])
    ->name('employer.jobs.applications');

Route::get('/part-timers/{id}', [PartTimerProfileController::class, 'show'])
    ->middleware(['auth'])
    ->name('part-timers.show');

Route::patch('/applications/{application}', [JobApplicationController::class, 'updateStatus'])
    ->middleware(['auth'])
    ->name('application.update');
    
Route::get('/employers/applicants/{id}', [JobApplicationController::class, 'viewApplicant'])
    ->middleware(['auth'])
    ->name('employers.viewApplicant');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/employers', [AdminController::class, 'manageEmployers'])->name('admin.employers');
    Route::get('/admin/employers/{id}', [AdminController::class, 'viewEmployer'])->name('admin.employer.view');
    Route::delete('/admin/employers/{id}', [AdminController::class, 'deleteEmployer'])->name('admin.employer.delete');

    Route::get('/admin/part-timers', [AdminController::class, 'managePartTimers'])->name('admin.partTimers');
    Route::get('/admin/part-timers/{id}', [AdminController::class, 'viewPartTimer'])->name('admin.partTimer.view');
    Route::delete('/admin/part-timers/{id}', [AdminController::class, 'deletePartTimer'])->name('admin.partTimer.delete');

    Route::get('/admin/jobs', [AdminController::class, 'manageJobs'])->name('admin.jobs');
    Route::post('/admin/jobs/{id}/approve', [AdminController::class, 'approveJob'])->name('admin.jobs.approve');
    Route::post('/admin/jobs/{id}/reject', [AdminController::class, 'rejectJob'])->name('admin.jobs.reject');

    Route::get('/reports', [AdminController::class, 'manageReports'])->name('admin.reports');
    Route::get('/reports/{id}', [AdminController::class, 'viewReport'])->name('admin.reports.view');
    Route::delete('/reports/{id}', [AdminController::class, 'deleteReport'])->name('admin.reports.delete');
});

Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Messaging Page
Route::get('/messages', function () {
    return view('chatify.index');
})->middleware('auth');


Route::get('/events/{event}/rate/{toUser}/{type}', [RatingController::class, 'create'])->name('ratings.create');
Route::post('/events/{event}/rate', [RatingController::class, 'store'])->name('events.rate');
Route::get('/ratings/{userId}', [RatingController::class, 'showRatings'])->name('ratings.show');

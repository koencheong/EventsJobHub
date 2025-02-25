<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    // Apply for a Job
    public function applyForJob(Request $request, $eventId)
    {
        try {
            $user = Auth::user();

            if (!$user || $user->role !== 'part-timer') {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Check if the user already applied
            $existingApplication = JobApplication::where('user_id', $user->id)
                                                ->where('event_id', $eventId)
                                                ->first();

            if ($existingApplication) {
                return response()->json(['message' => 'You have already applied for this job.']);
            }

            // Save the application
            JobApplication::create([
                'user_id' => $user->id,
                'event_id' => $eventId,
            ]);

            return response()->json(['message' => 'Application successful!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function partTimerDashboard()
    {
        $userId = Auth::id(); // Get logged-in part-timer's ID

        // Fetch applications with related event details using 'user_id'
        $applications = JobApplication::with('event')
                        ->where('user_id', $userId)
                        ->get();

        return view('part-timers.dashboard', compact('applications'));
    }

}

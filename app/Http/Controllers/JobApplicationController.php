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

        // Fetch applications with related event details
        $applications = JobApplication::with('event')
                        ->where('user_id', $userId)
                        ->get();

        // Count completed and upcoming jobs
        $completedJobs = JobApplication::where('user_id', $userId)
                        ->where('status', 'paid')
                        ->count();

        $upcomingJobs = JobApplication::where('user_id', $userId)
                        ->where('status', 'approved')
                        ->count();

        // Calculate total earnings (only from 'paid' applications)
        $totalEarnings = JobApplication::where('job_applications.user_id', $userId)
                        ->where('job_applications.status', 'paid')
                        ->join('events', 'job_applications.event_id', '=', 'events.id')
                        ->whereMonth('job_applications.updated_at', now()->month)
                        ->sum('events.payment_amount'); // Fetch from the events table

                        $earningsDataCollection = JobApplication::where('job_applications.user_id', $userId)
                        ->where('job_applications.status', 'paid')
                        ->join('events', 'job_applications.event_id', '=', 'events.id')
                        ->whereMonth('job_applications.updated_at', now()->month)
                        ->selectRaw('DATE(job_applications.updated_at) as date, SUM(events.payment_amount) as total')
                        ->groupByRaw('DATE(job_applications.updated_at)') // Fix grouping
                        ->orderBy('date', 'asc')
                        ->get();
                    
        // Convert to Chart.js format
        $earningsData = [
            'dates' => $earningsDataCollection->pluck('date')->toArray(),
            'amounts' => $earningsDataCollection->pluck('total')->toArray(),
        ];
                    
        return view('part-timers.dashboard', compact('applications', 'completedJobs', 'upcomingJobs', 'totalEarnings', 'earningsData'));
    }                    

    public function cancel($id)
    {
        $application = JobApplication::findOrFail($id);

        if ($application->status === 'pending') {
            $application->update(['status' => 'canceled']);
        }

        return redirect()->back()->with('success', 'Application canceled successfully.');
    }

    public function checkApplication($eventId)
    {
        $user = auth()->user();
        $alreadyApplied = JobApplication::where('event_id', $eventId)
                                        ->where('user_id', $user->id)
                                        ->exists();

        return response()->json(['alreadyApplied' => $alreadyApplied]);
    }

    // Employer
    public function listJobs()
    {
        if (auth()->user()->role !== 'employer') {
            abort(403, 'Unauthorized');
        }
    
        $jobs = Event::where('company_id', auth()->id())->withCount('applications')->get();
        return view('employers.jobs', compact('jobs'));
    }

    public function viewApplications(Event $job)
    {
        $applications = JobApplication::where('event_id', $job->id)
                        ->with('user')
                        ->get();
        
        return view('employers.job_applications', compact('job', 'applications'));
    }

    public function viewApplicant($id)
    {
        $employer = auth()->user();
        
        if ($employer->role !== 'employer') {
            abort(403, 'Unauthorized');
        }
    
        // Ensure the part-timer applied for a job posted by this employer
        $application = JobApplication::where('user_id', $id)
            ->whereHas('event', function ($query) use ($employer) {
                $query->where('company_id', $employer->id);
            })
            ->with('user.partTimerProfile') // Load the profile details
            ->first();
    
        if (!$application) {
            abort(403, 'Unauthorized');
        }
    
        // Ensure we get the part-timer profile
        $partTimerProfile = $application->user->partTimerProfile ?? null;
    
        return view('employers.view_applicant', ['partTimer' => $partTimerProfile]);
    }    
    
    public function updateStatus(Request $request, JobApplication $application)
    {
        if (auth()->user()->role !== 'employer') {
            abort(403, 'Unauthorized');
        }
    
        // Prevent status modification if it is already in a final state
        if (in_array($application->status, ['completed', 'paid', 'canceled'])) {
            return redirect()->back()->with('error', 'You cannot modify this application anymore.');
        }
    
        $request->validate([
            'status' => 'required|in:pending,approved,completed,rejected,paid,canceled'
        ]);
    
        $application->update(['status' => $request->status]);
    
        return redirect()->back()->with('success', 'Job status updated successfully.');
    }
    

}

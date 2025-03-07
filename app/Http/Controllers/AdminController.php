<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use App\Notifications\JobApproved;
use App\Notifications\JobRejected;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Show employers list
    public function manageEmployers()
    {
        $employers = User::where('role', 'employer')->get();
        return view('admin.employers', compact('employers'));
    }

    // View employer details
    public function viewEmployer($id)
    {
        $employer = User::where('id', $id)->where('role', 'employer')->firstOrFail();
        return view('admin.viewEmployer', compact('employer'));
    }

    // Delete an employer
    public function deleteEmployer($id)
    {
        $employer = User::where('id', $id)->where('role', 'employer')->firstOrFail();
        $employer->delete();

        return redirect()->route('admin.employers')->with('success', 'Employer deleted successfully.');
    }

    // Show part-timers list
    public function managePartTimers()
    {
        $partTimers = User::where('role', 'part-timer')->get();
        return view('admin.partTimers', compact('partTimers'));
    }

    // View part-timer details
    public function viewPartTimer($id)
    {
        $partTimer = User::where('id', $id)->where('role', 'part-timer')->firstOrFail();
        return view('admin.viewPartTimer', compact('partTimer'));
    }

    // Delete a part-timer
    public function deletePartTimer($id)
    {
        $partTimer = User::where('id', $id)->where('role', 'part-timer')->firstOrFail();
        $partTimer->delete();

        return redirect()->route('admin.partTimers')->with('success', 'Part-timer deleted successfully.');
    }

    // Show all job listings
    public function manageJobs()
    {
        $jobs = Event::with('employer')->get();
        return view('admin.jobs', compact('jobs'));
    }

    // Approve a job posting
    public function approveJob($id)
    {
        $job = Event::findOrFail($id);
        $job->status = 'approved';
        $job->save();

       
        if ($job->employer) { 
            $job->employer->notify(new JobApproved($job));
        } else {
            \Log::error("Job ID {$job->id} has no associated employer.");
        }
        
        return redirect()->route('admin.jobs')->with('success', 'Job approved successfully.');
    }

    // Reject a job posting
    public function rejectJob(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
    
        $job = Event::findOrFail($id);
        $job->status = 'rejected';
        $job->rejection_reason = $request->input('rejection_reason');
        $job->save();

        if ($job->employer) { 
            $job->employer->notify(new JobRejected($job));
        } else {
            \Log::error("Job ID {$job->id} has no associated employer.");
        }
    
        return redirect()->back()->with('error', 'Job has been rejected.');
    }
    

    // Manage reports
    public function manageReports()
    {
        $reports = Report::latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function viewReport($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.view', compact('report'));
    }

    public function deleteReport($id)
    {
        Report::findOrFail($id)->delete();
        return redirect()->route('admin.reports')->with('success', 'Report deleted successfully.');
    }


}

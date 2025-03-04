<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

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

        return redirect()->route('admin.jobs')->with('success', 'Job approved successfully.');
    }

    // Reject a job posting
    public function rejectJob($id)
    {
        $job = Event::findOrFail($id);
        $job->status = 'rejected';
        $job->save();

        return redirect()->route('admin.jobs')->with('success', 'Job rejected successfully.');
    }
}

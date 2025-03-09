<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewReport;

class ReportController extends Controller
{
    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $report = Report::create([
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewReport($report));
        }

        if (Auth::user()->role === 'employer') {
            return redirect()->route('dashboard')->with('success', 'Report submitted successfully!');
        } else {
            return redirect()->route('part-timers.dashboard')->with('success', 'Report submitted successfully!');
        }
    }

    public function index()
    {
        $reports = Report::latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    public function updateStatus(Report $report)
    {
        $report->update(['status' => 'resolved']);
        return back()->with('success', 'Report marked as resolved.');
    }

    public function view($id)
    {
        $report = Report::findOrFail($id);
        return view('admin.reports.view', compact('report'));
    }

}

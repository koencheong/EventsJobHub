<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;

class RatingController extends Controller
{
    public function create($eventId, $toUserId, $type)
    {
        $event = Event::findOrFail($eventId);
        $toUser = User::findOrFail($toUserId);

        return view('ratings.create', compact('event', 'toUser', 'type'));
    }

    public function store(Request $request, $eventId)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'type' => 'required|in:part_timer_to_employer,employer_to_part_timer',
        ]);
    
        // Get current logged-in user
        $fromUserId = Auth::id();
    
        // Determine who is rating whom
        if ($request->type == 'employer_to_part_timer') {
            // Employer rating part-timer
            $jobApplication = JobApplication::where('event_id', $eventId)
                ->where('user_id', $request->to_user_id)
                ->first();
    
            if (!$jobApplication) {
                return $this->redirectToDashboard()->with('error', 'Job application not found.');
            }
    
            if (!in_array($jobApplication->status, ['completed', 'paid'])) {
                return $this->redirectToDashboard()->with('error', 'You can only rate a part-timer after the job is completed or paid.');
            }
    
            $toUserId = $jobApplication->user_id; // The part-timer being rated
        } 
        else {
            // Part-timer rating employer
            $jobApplication = JobApplication::where('event_id', $eventId)
                ->where('user_id', $fromUserId) // Ensure the logged-in user is the part-timer
                ->first();
    
            if (!$jobApplication) {
                return $this->redirectToDashboard()->with('error', 'Job application not found.');
            }
    
            if ($jobApplication->status != 'paid') {
                return $this->redirectToDashboard()->with('error', 'You can only rate after payment is completed.');
            }
    
            $toUserId = Event::where('id', $eventId)->value('company_id'); // The employer being rated
        }
    
        // Prevent duplicate ratings
        $existingRating = Rating::where('event_id', $eventId)
                                ->where('from_user_id', $fromUserId)
                                ->where('to_user_id', $toUserId)
                                ->where('type', $request->type)
                                ->first();
    
        if ($existingRating) {
            return $this->redirectToDashboard()->with('error', 'You have already rated this user for this event.');
        }
    
        // Store rating
        Rating::create([
            'event_id' => $eventId,
            'from_user_id' => $fromUserId,
            'to_user_id' => $toUserId,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'type' => $request->type,
        ]);
    
        return $this->redirectToDashboard()->with('success', 'Your rating has been submitted.');
    }
    
    public function showRatings($userId)
    {
        $user = User::findOrFail($userId);
        $ratings = Rating::where('to_user_id', $userId)->latest()->get();

        return view('ratings.show', compact('user', 'ratings'));
    }

    /**
     * Redirect user to the correct dashboard based on role.
     */
    private function redirectToDashboard()
    {
        $user = auth()->user();
        
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'employer') {
            return redirect()->route('employer.jobs'); // Redirect to Manage Jobs
        } elseif ($user->role == 'part-timer') {
            return redirect()->route('part-timers.dashboard'); // Part-Timer Dashboard
        }
    
        return redirect('/'); // Default fallback
    }
    

}

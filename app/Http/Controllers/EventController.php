<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function showEventsForPartTimers(Request $request)
    {
        $events = Event::where('start_date', '>=', now()->toDateString())
            ->where('status', 'approved') // Assuming 'approved' is stored as a string
            ->orderBy('start_date')
            ->paginate(10);
    
        return view('home', compact('events'));
    }
    
    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_type' => 'required|string',
            'other_job_type' => 'required_if:job_type,Others|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'payment_amount' => 'required|numeric|min:0',
            'job_photos' => 'nullable|array',
            'job_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle file uploads
        $jobPhotos = [];
        if ($request->hasFile('job_photos')) {
            foreach ($request->file('job_photos') as $photo) {
                $path = $photo->store('job_photos', 'public'); // Store in storage/app/public/job_photos
                $jobPhotos[] = $path; // Add new photo path to array
            }
        }
    
        // Create the event and store job photos as JSON (same as update)
        $event = Event::create([
            'name' => $request->name,
            'job_type' => $request->job_type,
            'other_job_type' => $request->job_type === 'Others' ? $request->other_job_type : null,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'payment_amount' => $request->payment_amount,
            'company_id' => auth()->id(),
            'job_photos' => json_encode($jobPhotos), // Save photo paths as JSON
        ]);
    
        return redirect()->route('employer.jobs')->with('success', 'Event created successfully!');
    }
    

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_type' => 'required|string',
            'other_job_type' => 'nullable|required_if:job_type,Others|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'payment_amount' => 'required|numeric|min:0',
        ]);
    
        // Decode existing photos to an array (handle null case)
        $existingPhotos = is_array($event->job_photos) ? $event->job_photos : json_decode($event->job_photos, true) ?? [];
    
        // Handle photo removal
        if ($request->has('remove_photos')) {
            foreach ($request->remove_photos as $photo) {
                Storage::delete('public/' . $photo); // Delete from storage
                $existingPhotos = array_diff($existingPhotos, [$photo]); // Remove from array
            }
        }
    
        // Handle new photo uploads
        if ($request->hasFile('job_photos')) {
            foreach ($request->file('job_photos') as $photo) {
                $path = $photo->store('job_photos', 'public'); // Store in storage/app/public/job_photos
                $existingPhotos[] = $path; // Add new photo to array
            }
        }
    
        // Save updated photo list
        $event->update([
            'name' => $request->name,
            'job_type' => $request->job_type,
            'other_job_type' => $request->job_type === 'Others' ? $request->other_job_type : null,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'payment_amount' => $request->payment_amount,
            'job_photos' => json_encode(array_values($existingPhotos)), // Ensure JSON format
        ]);
    
        return redirect()->route('employer.jobs')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('employer.jobs')->with('success', 'Event deleted successfully!');
    }
}
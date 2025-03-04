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
        $query = Event::where('status', 'approved'); // Keep it as a query builder

        // Search by event name, location, or job type
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%')
                ->orWhere('job_type', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by Job Type
        if ($request->has('job_type') && $request->job_type != '') {
            $query->where('job_type', $request->job_type);
        }

        // Filter by Payment Range
        if ($request->has('min_payment') && is_numeric($request->min_payment)) {
            $query->where('payment_amount', '>=', $request->min_payment);
        }

        if ($request->has('max_payment') && is_numeric($request->max_payment)) {
            $query->where('payment_amount', '<=', $request->max_payment);
        }

        // Filter by Date Range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
    
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('end_date', '<=', $request->end_date);
        }
    
        // Fetch the filtered events with pagination
        $events = $query->paginate(10);

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
                $jobPhotos[] = $path;
            }
        }
    
        // Event::create([
        //     'name' => $request->name,
        //     'job_type' => $request->job_type,
        //     'other_job_type' => $request->job_type === 'Others' ? $request->other_job_type : null,
        //     'description' => $request->description,
        //     'start_date' => $request->start_date,
        //     'end_date' => $request->end_date,
        //     'location' => $request->location,
        //     'payment_amount' => $request->payment_amount,
        //     'company_id' => auth()->id(),
        //     'job_photos' => $jobPhotos, // Save photo paths
        // ]);

        Event::create([
            'name' => $request->name,
            'job_type' => $request->job_type,
            'other_job_type' => $request->job_type === 'Others' ? $request->other_job_type : null,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'payment_amount' => $request->payment_amount,
            'company_id' => auth()->id(),
            'job_photos' => $jobPhotos,
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
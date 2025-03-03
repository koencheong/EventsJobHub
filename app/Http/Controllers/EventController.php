<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

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
        $query = Event::query();
    
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
    
        // Fetch the filtered events
        $events = $query->get();
    
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
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date', // Ensure end_date is after or equal to start_date
            'location' => 'required|string',
            'payment_amount' => 'required|numeric|min:0',
        ]);
    
        Event::create([
            'name' => $request->name,
            'job_type' => $request->job_type,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'payment_amount' => $request->payment_amount,
            'company_id' => auth()->id(),
        ]);
    
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
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
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date', // Ensure end_date is after or equal to start_date
            'location' => 'required|string',
            'payment_amount' => 'required|numeric|min:0',
        ]);

        $event->update([
            'name' => $request->name,
            'job_type' => $request->job_type,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'payment_amount' => $request->payment_amount,
        ]);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

}

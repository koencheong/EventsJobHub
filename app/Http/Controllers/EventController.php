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
        // Get the search query from the request
        $search = $request->get('search');

        // Fetch events with optional search functionality
        if ($search) {
            $events = Event::where('name', 'like', '%' . $search . '%')
                            ->orWhere('location', 'like', '%' . $search . '%')
                            ->orWhere('job_type', 'like', '%' . $search . '%')
                            ->get();
        } else {
            $events = Event::all();
        }

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
            'date' => 'required|date',
            'location' => 'required|string',
        ]);

        Event::create([
            'name' => $request->name,
            'job_type' => $request->job_type,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'company_id' => auth()->id(), // Assuming only logged-in employers can post
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
            'date' => 'required|date',
            'location' => 'required|string',
        ]);

        $event->update($request->all());

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

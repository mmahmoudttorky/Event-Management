<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Display the form for creating a new event
    public function create()
    {
        return view('events.create');
    }

    // Store a new event
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'description' => 'required',
        //     'date' => 'required|date',
        //     'location' => 'required',
        //     'ticket_limit' => 'required|integer',
        // ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'ticket_limit' => 'required|integer|min:1'
            //,'available_tickets' => 'required|integer|min:0', // Validate available_tickets
        ]);

        $event = new Event();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->location = $request->location;
        $event->ticket_limit = $request->ticket_limit;
        $event->available_tickets = $request->ticket_limit;
        $event->organizer_id = Auth::id();
        $event->save();

        // Event::create([
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'date' => $request->date,
        //     'location' => $request->location,
        //     'ticket_limit' => $request->ticket_limit,
        //     'available_tickets' => $request->ticket_limit, 
        //     'organizer_id' => auth()->id(), // Assuming you are using auth
        // ]);

        return redirect('/events')->with('success', 'Event created successfully');
    }

    // Display all events
    public function index()
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // Check if the user is an organizer or participant
        if ($user->role === 'organizer') {
            // If the user is an organizer, show only events they own
            $events = Event::where('organizer_id', $user->id)->get();
        } else {
            // If the user is a participant, show all available events
            $events = Event::with('organizer')->get();
        }

        // Pass the events to the view
        return view('events.index', compact('events'));
    }
    //TODO 
    // show events that have tickts
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;


class TicketController extends Controller
{
    // Create a ticket for the event
    public function store(Request $request)
    {
        $event = Event::findOrFail($request->event_id);

        // Check if there are available tickets
        if ($event->available_tickets > 0 && $event->date >= Carbon::today() ) {
            // Create a unique ticket number
            $ticket_number = rand(100000, 999999);

            // Create a ticket for the user
            $ticket =Ticket::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'ticket_number' => $ticket_number,
            ]);

            // Decrease available tickets
            $event->available_tickets--;
            $event->save();
            $user = Auth::user();   

            Mail::to($user->email)->send(new RegistrationConfirmation($ticket, $event));

            return redirect()->route('tickets.index', $event->id)->with('success', 'You have successfully registered for the event. A confirmation email has been sent to you.');
        }

        return redirect()->route('tickets.index', $event->id)->with('error', 'No available tickets left.');
    }

    // View tickets for an event
    public function index($eventId)
    {
        $user = Auth::user(); // Get the currently logged-in user
    
        // Retrieve the event and filter tickets that belong to the logged-in user
        $event = Event::with(['tickets' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->findOrFail($eventId);
    
        return view('tickets.index', compact('event'));
    }
    
      // Organizer's view for managing tickets
      public function manage($eventId)
      {
          $user = Auth::user();
  
          // Fetch the event with tickets, but only if the user is the organizer
          $event = Event::with('tickets.user')->where('id', $eventId)->where('organizer_id', $user->id)->firstOrFail();
  
          // Show all tickets for the event
          $tickets = Ticket::where('event_id', $eventId)->get();
  
          return view('tickets.manage', compact('event', 'tickets'));
      }
  
      // Method for deleting a ticket
      public function destroy($ticketId)
      {
          $ticket = Ticket::findOrFail($ticketId);
          
          // Check if the logged-in user is the organizer of the event
          if (Auth::user()->id === $ticket->event->organizer_id) {
              $ticket->delete();
  
              // Increment available tickets for the event
              $ticket->event->increment('available_tickets');
  
              return redirect()->back()->with('success', 'Ticket deleted successfully.');
          }
  
          return redirect()->back()->with('error', 'Unauthorized action.');
      }
}

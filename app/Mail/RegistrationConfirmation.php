<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, Event $event)
    {
        $this->ticket = $ticket;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.registration_confirmation')
                    ->subject('Event Registration Confirmation')
                    ->with([
                        'ticket_number' => $this->ticket->ticket_number,
                        'event_name' => $this->event->name,
                        'event_date' => $this->event->date,
                        'event_location' => $this->event->location,
                    ]);
    }
}

@extends('layouts.app')

@section('content')
    <h2>Manage Tickets for Event: {{ $event->name }}</h2>

    <table>
        <thead>
            <tr>
                <th>Ticket Number</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Date Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->ticket_number }}</td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>{{ $ticket->user->email }}</td>
                    <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this ticket?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Available Tickets:</strong> {{ $event->available_tickets }}</p>
@endsection

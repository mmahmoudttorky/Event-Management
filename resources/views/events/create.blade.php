@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create a New Event') }}</div>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
        <form action="/events" method="POST">
            @csrf
            <label for="name">Event Name:</label>
            <input type="text" name="name" id="name" required><br><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea><br><br>

            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required><br><br>

            <label for="location">Location:</label>
            <input type="text" name="location" id="location" required><br><br>

            <label for="ticket_limit">Ticket Limit:</label>
            <input type="number" name="ticket_limit" id="ticket_limit" required><br><br>

            <button type="submit">Create Event</button>
        </form>
    </div>
    </div>
        </div>
    </div>
</div>
@endsection

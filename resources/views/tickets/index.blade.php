@extends('layouts.app')
@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Events') }}</div>
                </div>
                <div class="card-body">
                <h2>My Tickets for {{ $event->name }}</h2>
                @if($event->tickets->isEmpty())
                    <p>You haven't registered for this event yet.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Ticket Number</th>
                                <th>Date Issued</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->ticket_number }}</td>
                                    <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                </div>
            </div>
        </div>
    </div>
@endsection

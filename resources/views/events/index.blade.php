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
                <h1>Upcoming Events</h1>
                @foreach ($events as $event)
                    <h2>{{ $event->organizer->name }} -- 
                    @if(Auth::user()->role != 'participant')
                        <a href="{{ route('tickets.manage',$event->id) }}">{{ $event->name }}</a> 
                    @else
                        {{ $event->name }} 
                    @endif
                    </h2>
                    <p>{{ $event->description }}</p>
                    <p>Date: {{ $event->date }}</p>
                    <p>Location: {{ $event->location }}</p>
                    <p>Ticket Limit: {{ $event->ticket_limit }}</p>
                    <p>Available Ticktes: {{ $event->available_tickets }}</p>
                    @if($event->available_tickets != 0 && $event->date >= Carbon::today() && Auth::user()->role === 'participant')
                        <form action="{{ route('tickets.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <button type="submit">Register and Create Ticket</button>
                        </form>
                    @else
                        @if( Auth::user()->role != 'participant')
                             <!-- <p>Organizer Can't register a Ticket</p> -->
                        @else
                            <p>No tickets available</p>
                        @endif
                    @endif
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

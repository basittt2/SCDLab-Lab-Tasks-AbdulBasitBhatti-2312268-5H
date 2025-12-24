@extends('app')

@section('content')
<h2>Event Submitted Successfully</h2>

<ul class="list-group">
    <li class="list-group-item"><strong>Name:</strong> {{ $event['name'] }}</li>
    <li class="list-group-item"><strong>Date:</strong> {{ $event['date'] }}</li>
    <li class="list-group-item"><strong>Location:</strong> {{ $event['location'] }}</li>
    <li class="list-group-item"><strong>Description:</strong> {{ $event['description'] }}</li>
</ul>

<a href="{{ route('events.index') }}" class="btn btn-primary mt-3">Back to Events</a>
@endsection

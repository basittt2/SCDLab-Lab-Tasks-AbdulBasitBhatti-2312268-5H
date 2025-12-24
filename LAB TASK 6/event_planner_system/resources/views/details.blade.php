@extends('app')

@section('content')
<h2>Event Details</h2>

@isset($event)
<ul class="list-group">
    <li class="list-group-item"><strong>Name:</strong> {{ $event['name'] }}</li>
    <li class="list-group-item"><strong>Date:</strong> {{ $event['date'] }}</li>
    <li class="list-group-item"><strong>Location:</strong> {{ $event['location'] }}</li>
    <li class="list-group-item"><strong>Status:</strong> {{ $event['status'] }}</li>
    <li class="list-group-item"><strong>Description:</strong> {{ $event['description'] }}</li>
</ul>
@endisset
@endsection

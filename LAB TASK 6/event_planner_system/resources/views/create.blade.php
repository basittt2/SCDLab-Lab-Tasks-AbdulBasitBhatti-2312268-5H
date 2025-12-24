@extends('app')

@section('content')
<h2>Add New Event</h2>

<form action="{{ route('events.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Event Name</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
</form>
@endsection

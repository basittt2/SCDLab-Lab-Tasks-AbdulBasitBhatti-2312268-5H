@extends('app')

@push('styles')
<style>
    .Upcoming { color: green; font-weight: bold; }
    .Ongoing { color: orange; font-weight: bold; }
    .Completed { color: red; font-weight: bold; }
</style>
@endpush

@section('content')
<h2>Upcoming Events</h2>

@isset($events)
    @if(count($events) > 0)
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $id => $event)
                    <tr>
                        <td>{{ $event['name'] }}</td>
                        <td>{{ $event['date'] }}</td>
                        <td>{{ $event['location'] }}</td>
                        <td>
                            @if($event['status'] == 'Upcoming')
                                <span class="Upcoming">{{ $event['status'] }}</span>
                            @elseif($event['status'] == 'Ongoing')
                                <span class="Ongoing">{{ $event['status'] }}</span>
                            @else
                                <span class="Completed">{{ $event['status'] }}</span>
                            @endif
                        </td>
                        <td><a href="{{ route('events.details', $id) }}" class="btn btn-primary btn-sm">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No events available.</p>
    @endif
@endisset

@endsection

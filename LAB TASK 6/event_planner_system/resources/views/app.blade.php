<!DOCTYPE html>
<html>
<head>
    <title>Event Planner System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('events.index') }}">Event Planner</a>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('events.create') }}">Add Event</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>

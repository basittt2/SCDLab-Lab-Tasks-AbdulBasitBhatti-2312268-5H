<!DOCTYPE html>
<html>
<head>
    <title>Gaming Website - Contact Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Gaming Website</a>
        <div>
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5">
        <h1>Contact Us</h1>
        <p>You can reach out to us at <strong>contact@gamingwebsite.com</strong></p>
    </div>
</body>
</html>

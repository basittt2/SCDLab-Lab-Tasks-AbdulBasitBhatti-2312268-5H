<!DOCTYPE html>
<html>
<head>
    <title>Gaming Website - About</title>
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
        <h1>About Us</h1>
        <p>We provide the latest updates and insights about gaming. Our mission is to bring gamers together!</p>
    </div>
</body>
</html>

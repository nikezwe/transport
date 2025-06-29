<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
    <a href="{{ route('home') }}" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
        <img class="ms-3" src="img/icon.jpg" alt="" style="width: 40px; height: 40px;">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
            <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
            <a href="{{ route('service') }}" class="nav-item nav-link">Services</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu fade-up m-0">
                    {{-- <a href="{{ route('price') }}" class="dropdown-item">Pricing Plan</a> --}}
                    <a href="{{ route('feature') }}" class="dropdown-item">Features</a>
                    <a href="{{ route('quote') }}" class="dropdown-item">Free Quote</a>
                    <a href="{{ route('team') }}" class="dropdown-item">Our Team</a>
                    <a href="{{ route('testimonial') }}" class="dropdown-item">Testimonial</a>
                    {{-- <a href="{{ route('404') }}" class="dropdown-item">404 Page</a> --}}
                </div>
            </div>
            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact</a>
        </div>
        <h4 class="m-0 pe-lg-5 d-none d-lg-block"><i class="fa fa-headphones text-primary me-3"></i></h4>
    </div>
</nav>
</body>
</html>

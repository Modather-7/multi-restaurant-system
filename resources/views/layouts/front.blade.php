<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/utilities.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    @stack('styles')
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark fs-3" href="/">Food<span class="text-gold">Grids</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-3">
                <li class="nav-item"><a class="nav-link fw-semibold" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="/menu">Menu</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="contact.html">Contact</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="about.html">About</a></li>
                @guest
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="/register">Register</a></li>
                @endguest
                @auth
                    <li class="nav-item">
                        <form action="/logout" method="POST">
                            <button type="submit" class="nav-link fw-semibold">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth
                <li class="nav-item"><a class="btn btn-gold px-4 shadow-sm" href="cart.html">Cart</a></li>
            </ul>
        </div>
    </div>
</nav>

{{ $breadcrumb ?? '' }}

{{ $slot }}

<footer class="py-4 text-center text-muted border-top bg-white mt-auto">
    <div class="container">
        <small>&copy; 2026 FoodGrids. Powered by FoodGrids SaaS.</small>
    </div>
</footer>

<script src="{{ asset('assets/js/products.js') }}"></script>
<script src="{{ asset('assets/js/cart.js') }}"></script>
<script src="{{ asset('assets/js/auth.js') }}"></script>
<script src="{{ asset('assets/js/ui.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>

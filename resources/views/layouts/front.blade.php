<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'FoodGrids' }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg modern-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            Food<span class="text-gold">Grids</span>
        </a>
        <button class="navbar-toggler border-0 shadow-none"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <i class="lni lni-menu fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                <li><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a></li>
                <li><a class="nav-link {{ request()->is('menu*') ? 'active' : '' }}" href="/menu">Menu</a></li>
                <li><a class="nav-link" href="/contact">Contact</a></li>
                <li><a class="nav-link" href="/about">About</a></li>

                @guest
                    <li>
                        <a href="/login" class="btn btn-outline-dark btn-sm rounded-pill px-3 auth-btn">
                            Login
                        </a>
                    </li>

                    <li>
                        <a href="/register" class="btn btn-outline-dark btn-sm rounded-pill px-3 auth-btn">
                            Register
                        </a>
                    </li>
                @endguest

                @auth
                    <li>
                        <form action="/logout" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-outline-dark btn-sm rounded-pill px-3 logout-btn">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth

                <li>
                    <a href="/cart" class="cart-pill">
                        <i class="lni lni-cart"></i>
                        <span>Cart</span>
                        <span id="cart-badge-nav">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1">
    {{ $slot }}
</main>

<footer class="modern-footer">
    <div class="container text-center">
        <h6>Food<span class="text-gold">Grids</span></h6>
        <small>© 2026 All rights reserved</small>
    </div>
</footer>

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
@stack('scripts')

</body>
</html>

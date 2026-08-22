<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'FoodGrids' }}</title>

    @vite(['resources/js/app.js', 'resources/js/front.js'])

    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/LineIcons-rtl.3.0.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider-rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/glightbox-rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/main-rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=400;600;700;800&display=swap" rel="stylesheet">

    @stack('styles')

</head>
<body class="d-flex flex-column min-vh-100 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-authenticated="{{ auth()->check() ? '1' : '0' }}">

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg modern-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('restaurant.home', $restaurant) }}">Food<span class="text-gold">Grids</span></a>

         {{-- Computer Monitor Change Language --}}
        <li class="d-none d-lg-block">
            <a href="{{ route(
                request()->route()->getName(),
                array_merge(
                    request()->route()->parameters(),
                    [
                        'locale' => app()->getLocale() === 'ar' ? 'en' : 'ar'
                    ]
                )
            ) }}"
            class="lang-switch-desktop">
                <i class="lni lni-world"></i>
                {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
            </a>
        </li>

         {{-- Mobile Navbar --}}
        <div class="d-flex align-items-center gap-2 ml-auto d-lg-none">

            {{-- Localization --}}
            <a href="{{ route(
                request()->route()->getName(),
                array_merge(
                    request()->route()->parameters(),
                    [
                        'locale' => app()->getLocale() === 'ar' ? 'en' : 'ar'
                    ]
                )
            ) }}"
            class="lang-switch-mobile">
                <i class="lni lni-world"></i>
            </a>

             {{-- Cart --}}
            @if (!request()->routeIs('restaurant.home', $restaurant))
                <a href="{{ route('restaurant.cart.index', [$restaurant, $branch]) }}"
                class="cart-pill mobile-cart-pill">
                    <i class="lni lni-cart"></i>
                    <span id="cart-badge-nav">{{ \App\Helpers\CartCounter::count() }}</span>
                </a>
            @endif

            {{-- Navbar Menu --}}
            <button class="navbar-toggler border-0 shadow-none p-0"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <i class="lni lni-menu fs-4"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                @if (!request()->routeIs('restaurant.home', $restaurant))
                <li>
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                        href="{{ route('restaurant.home', $restaurant) }}">
                            {{ trans('home') }}
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->is('menu*') ? 'active' : '' }}"
                        href="{{ route('restaurant.menu.index', [$restaurant, $branch]) }}">
                            {{ trans('Menu') }}
                    </a>
                </li>
                <li><a class="nav-link" href="{{ route('restaurant.contact.index', [$restaurant, $branch]) }}">{{ trans('contact') }}</a></li>

                <li class="d-none d-lg-block">
                    <a href="{{ route('restaurant.cart.index', [$restaurant, $branch]) }}" class="cart-pill">
                        <i class="lni lni-cart"></i>
                        <span>{{ trans('cart') }}</span>
                        <span id="cart-badge-nav">{{ \App\Helpers\CartCounter::count() }}</span>
                    </a>
                </li>
                @endif

                @guest
                    <li>
                        <a href="?dialog=LOGIN" class="btn btn-outline-dark btn-sm rounded-pill px-3 auth-btn">
                            {{ trans('Log in') }}
                        </a>
                    </li>

                    <li>
                        <a href="?dialog=REGISTER" class="btn btn-outline-dark btn-sm rounded-pill px-3 auth-btn">
                            {{ trans('Register') }}
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item dropdown position-relative">
                        <a class="nav-link dropdown-toggle btn btn-outline-dark btn-sm rounded-pill px-3 d-flex align-items-center justify-content-center justify-content-lg-start gap-2 backend-user-dropdown"
                           href="#"
                           id="userDropdown"
                           role="button"
                           aria-expanded="false">
                            <i class="lni lni-user fs-6"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3" id="userDropdownMenu" aria-labelledby="userDropdown">
                            <li>
                                <span class="dropdown-item-text text-muted small pb-2 border-bottom d-block">
                                    {{ auth()->user()->email }}
                                </span>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2 w-100 text-start align-items-center d-flex">
                                        <i class="lni lni-exit me-2"></i> {{ trans('Log Out') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1">
    {{ $slot }}
</main>

@guest
    <div class="auth-overlay" data-auth-overlay hidden role="presentation">
        <div class="auth-modal" role="dialog" aria-modal="true" aria-label="{{ trans('Log in') }}">
            <button class="auth-close" type="button" aria-label="{{ trans('Close') }}">&times;</button>
            <div class="auth-pane" data-auth-pane="LOGIN" hidden>@include('front.auth.login')</div>
            <div class="auth-pane" data-auth-pane="REGISTER" hidden>@include('front.auth.register')</div>
        </div>
    </div>
@endguest

@stack('scripts')

</body>
</html>

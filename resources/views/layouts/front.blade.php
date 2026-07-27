<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'FoodGrids' }}</title>

    @vite(['resources/js/app.js'])

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
<body class="d-flex flex-column min-vh-100 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg modern-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('restaurant.home', $restaurant) }}">Food<span class="text-gold">Grids</span></a>

        <a href="{{ route(
            request()->route()->getName(),
            array_merge(
                request()->route()->parameters(),
                [
                    'locale' => app()->getLocale() === 'ar' ? 'en' : 'ar'
                ]
            )
        ) }}"
        class="btn btn-sm btn-outline-dark rounded-pill">
            {{ app()->getLocale() === 'ar' ? 'English US' : 'العربية EG' }}
        </a>

        <div class="d-flex align-items-center gap-2 ml-auto d-lg-none">
            {{-- زر السلة المخصص للموبايل يظهر خارج القائمة --}}
            @if (!request()->routeIs('restaurant.home', $restaurant))
                <a href="{{ route('restaurant.cart.index', [$restaurant, $branch]) }}" class="cart-pill mobile-cart-pill">
                    <i class="lni lni-cart"></i>
                    <span id="cart-badge-nav">{{ \App\Helpers\CartCounter::count() }}</span>
                </a>
            @endif

            <button class="navbar-toggler border-0 shadow-none p-0"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
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
                            {{ trans('menu') }}
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
    @if(request('dialog') && !auth()->check())
    <div class="auth-overlay">
        <div class="auth-modal">
            <button class="auth-close">&times;</button>
            @if(request('dialog') == 'LOGIN')
                @include('front.auth.login')
            @elseif(request('dialog') == 'REGISTER')
                @include('front.auth.register')
            @endif
        </div>
    </div>
    @endif
@endguest

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const closeButton = document.querySelector('.auth-close');
        const overlay = document.querySelector('.auth-overlay');

        function closeAuthModal() {
            if (overlay) {
                let url = new URL(window.location.href);
                if (url.searchParams.has('dialog')) {
                    url.searchParams.delete('dialog');
                    window.history.replaceState({}, document.title, url.pathname + url.search);
                }
                overlay.remove();
            }
        }

        closeButton?.addEventListener('click', closeAuthModal);

        if (overlay) {
            document.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeAuthModal();
                }
            });
        }

        @auth
            let url = new URL(window.location.href);
            if(url.searchParams.has('dialog')){
                url.searchParams.delete('dialog');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        @endauth

        const userDropdown = document.getElementById('userDropdown');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (userDropdown && userDropdownMenu) {
            userDropdown.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const isShown = userDropdownMenu.classList.contains('show');

                userDropdown.classList.remove('show');
                userDropdownMenu.classList.remove('show');
                userDropdown.setAttribute('aria-expanded', 'false');

                if (!isShown) {
                    userDropdown.classList.add('show');
                    userDropdownMenu.classList.add('show');
                    userDropdown.setAttribute('aria-expanded', 'true');
                }
            });

            document.addEventListener('click', function (e) {
                if (!userDropdown.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdown.classList.remove('show');
                    userDropdownMenu.classList.remove('show');
                    userDropdown.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });

    window.addEventListener('pageshow', function (event) {
        if (event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
</script>

</body>
</html>

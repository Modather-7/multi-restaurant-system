<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Branch</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    
    @vite(['resources/js/app.js'])
</head>

<body class="foodgrids-branch-body grid-bg">

    <div class="container branch-grid-wrapper">

        <div class="branch-grid-header text-center">
            <h1 class="hero-title">Select Your Branch</h1>
            <p class="hero-desc mx-auto">Choose the nearest branch to explore our menu and start your order.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($branches as $branch)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <form action="{{ route('restaurant.branches.select', [$restaurant, $branch]) }}" method="POST"
                        class="h-100">
                        @csrf
                        <button type="submit" class="grid-branch-card">

                            <div class="branch-card-top">
                                <div class="branch-icon-box">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <h3 class="grid-branch-name">{{ $branch->name }}</h3>
                            </div>

                            <div class="branch-card-footer">
                                <span class="action-text">Order Now</span>
                            </div>

                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>

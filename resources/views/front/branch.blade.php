<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Location | FoodGrids</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])
</head>

<body class="foodgrids-branch-body dots-bg">

    <div class="container branch-container">

        <div class="branch-minimal-header text-center mb-5">
            <h1 class="branch-title">Select Location</h1>
            <p class="branch-subtitle">Choose a branch to view the menu and order</p>
        </div>

        {{-- تقسيم الـ Grid: يعرض كرتين بجانب بعض في الشاشات الكبيرة وكرت واحد في الموبايل --}}
        <div class="row g-4 justify-content-center">
            @foreach ($branches as $branch)
                <div class="col-12 col-md-6">

                    <div class="restaurant-branch-row-card" onclick="document.getElementById('branch-form-{{ $branch->id }}').submit();">

                        <form id="branch-form-{{ $branch->id }}" action="{{ route('restaurant.branches.select', [$restaurant, $branch]) }}" method="POST" class="d-none">
                            @csrf
                        </form>

                        {{-- جانب البيانات --}}
                        <div class="branch-details-area">
                            <div class="branch-top-meta">
                                <h3 class="branch-card-name">{{ $branch->name }}</h3>
                                <span class="branch-status-badge open">Open</span>
                            </div>
                        </div>

                        {{-- دائرة الاختيار (Radio UI) --}}
                        <div class="branch-select-radio">
                            <div class="radio-circle-ui"></div>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    </div>

</body>
</html>

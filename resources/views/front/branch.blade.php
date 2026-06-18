<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Branch</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <style>
        body {
            min-height: 100vh;
            background: #f8f9fa;
            display: flex;
            align-items: center;
        }

        .branch-wrapper {
            width: 100%;
            padding: 40px 0;
        }

        .branch-card {
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,.04);
        }

        .branch-title {
            font-size: 32px;
            font-weight: 500;
            color: #111;
            margin-bottom: 10px;
        }

        .branch-subtitle {
            color: #777;
            margin-bottom: 30px;
        }

        .branch-item {
            display: block;
            text-decoration: none;

            padding: 18px 20px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;

            transition: .2s ease;
            color: #111;
        }

        .branch-item:hover {
            border-color: #d4af37;
            transform: translateY(-2px);
            color: #111;
        }

        .branch-name {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .branch-phone {
            color: #777;
            font-size: 14px;
        }

        .branch-status {
            font-size: 13px;
            color: #22c55e;
        }
    </style>
</head>

<body>

    <div class="container branch-wrapper">

        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="branch-card">

                    <h1 class="branch-title">
                        Select Your Branch
                    </h1>

                    <p class="branch-subtitle">
                        Choose the branch you'd like to order from.
                    </p>

                    <div class="d-grid gap-3">

                        @foreach ($branches as $branch)

                        <form action="{{ route('restaurant.branches.select', [$restaurant, $branch]) }}"
                            method="POST">

                            @csrf

                            <button type="submit" class="branch-item w-100">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>
                                        <div class="branch-name">
                                            {{ $branch->name }}
                                        </div>

                                        @if($branch->phone)
                                            <div class="branch-phone">
                                                {{ $branch->phone }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="branch-status">
                                        Available
                                    </div>

                                </div>

                            </button>

                        </form>

                        @endforeach

                    </div>

                </div>

            </div>
        </div>

    </div>

</body>

</html>

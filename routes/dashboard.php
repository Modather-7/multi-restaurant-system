<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group([
        'middleware' => ['auth', 'verified'],
        'as' => 'dashboard.', //all routes should start with (dashboard.) -> 'dashboard.products.create'
        'prefix' => 'dashboard', //all routes in this group starts with dashboard in the url
    ], function() {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/products/trash', [ProductController::class, 'trash'])
            ->name('products.trash');
        Route::put('products/{product}/restore', [ProductController::class, 'restore'])
            ->name('products.restore');
        Route::delete('products/{product}/force-delete', [ProductController::class, 'forceDelete'])
            ->name('products.force-delete');
        Route::resource('products', ProductController::class);

        Route::resource('categories', CategoryController::class);
    });

Route::get('dashboard/pages', [DashboardController::class, 'pages'])
    ->middleware(['auth', 'verified']);

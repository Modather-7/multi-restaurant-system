<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group([
        'middleware' => ['auth'],
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

        Route::get('/categories/trash', [CategoryController::class, 'trash'])
            ->name('categories.trash');
        Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])
            ->name('categories.restore');
        Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])
            ->name('categories.force-delete');
        Route::resource('categories', CategoryController::class);
    });

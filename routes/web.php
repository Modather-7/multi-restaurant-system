<?php

use App\Http\Controllers\Front\BranchController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

require __DIR__.'/admin-auth.php';

require __DIR__.'/dashboard.php';

Route::group([
        'prefix' => '{locale}',
        'where' => ['locale' => 'ar|en'],
        'middleware' => 'set.locale',
    ], function() {
    Route::group([

        'prefix' => '{restaurant:slug}',
        'as' => 'restaurant.'
    ], function() {
        Route::get('/', [HomeController::class, 'index'])
            ->name('home');

        Route::get('/branches', [BranchController::class, 'index'])
            ->name('branches');

        Route::post('/branches/{branch}', [BranchController::class, 'select'])
            ->name('branches.select');

        Route::group([
                'middleware' => 'branch.selected',
                'prefix' => '{branch:name}'
            ],
                function () {
                Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
                Route::get('/menu/{product:slug}', [MenuController::class, 'show'])->name('menu.show');

                Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

                Route::resource('cart', CartController::class);

                Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
                Route::post('/checkout', [CheckoutController::class, 'store']);
            });
    });

});

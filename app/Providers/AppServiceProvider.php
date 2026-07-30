<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepository::class, function(){
            return new CartModelRepository();
        });

        // Gate::define('categories.view', function($user) {
        //     return true;
        // });

        // Gate::define('categories.create', function($user) {
        //     return false;
        // });

        // Gate::define('categories.update', function($user) {
        //     return true;
        // });

        // Gate::define('categories.delete', function($user) {
        //     return false;
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

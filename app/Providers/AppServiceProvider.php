<?php

namespace App\Providers;

use App\Models\Admin;
use App\Policies\RolePolicy;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

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

        Gate::before(function ($user, string $ability) {
            if ($user instanceof Admin && $user->super_admin) {
                return true;
            }
        });

        Gate::policy(Role::class, RolePolicy::class);
    }
}

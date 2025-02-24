<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction()); // Prevent N+1 problem
        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction()); // Prevent not giving error when mass assignment "$fillsable is not set"
        Blade::if('isAdmin', fn() => auth()->check() && auth()->user()->isAdmin());
        Blade::if('isUser', fn() => auth()->check() && auth()->user()->isUser());
    }
}

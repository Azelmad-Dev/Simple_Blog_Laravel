<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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

        // When saving polymorphic relations, store 'post' or 'video' instead of 'App\Models\Post' or 'App\Models\Video'
        Relation::enforceMorphMap([
            'post' => 'App\Models\Post',
            'video' => 'App\Models\Video',
        ]);
    }
}

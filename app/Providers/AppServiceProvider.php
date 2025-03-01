<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Catalog;
use App\Observers\CatalogObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    protected $listen = [
        'App\Events\CatalogChanged' => [
            'App\Listeners\LogCatalogChange',
        ],
    ];
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Catalog::observe(CatalogObserver::class);
    }
}

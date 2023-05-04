<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
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
        // set timezone to Asia/Jakarta
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // using bootstrap 5 pagination
        Paginator::useBootstrapFive();
    }
}

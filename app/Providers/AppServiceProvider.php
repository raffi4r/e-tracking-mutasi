<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // Jika kamu ingin menambahkan binding atau helper khusus, taruh di sini.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Misalnya: set default string length untuk MySQL lama
        // Schema::defaultStringLength(191);
    }
}

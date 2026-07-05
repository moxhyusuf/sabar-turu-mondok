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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('layouts_user.app', function ($view) {
            $items = \App\Models\Kost::with('images')
                ->latest()
                ->take(6)
                ->get();

            $view->with('items', $items);
        });
    }
}

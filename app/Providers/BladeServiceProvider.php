<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('currency', function ($currency) {
            return
                "<?php
                echo number_format($currency, 2) . ' €'
            ?>";
        });

        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && auth()->user()->is_admin): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

    }
}

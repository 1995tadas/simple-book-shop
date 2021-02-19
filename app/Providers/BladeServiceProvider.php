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
            echo ($currency != 0)
            ? number_format($currency, 2) . ' €'
            : __('book.free')
            ?>";
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AcfBlocksServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // require_once get_theme_file_path('app/acf-blocks.php');
    }
}
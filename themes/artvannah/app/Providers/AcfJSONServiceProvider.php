<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AcfJSONServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // require_once get_theme_file_path('app/acf-json.php');
    }
}
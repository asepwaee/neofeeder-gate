<?php

namespace Aseplab\Neofeeder;

use Illuminate\Support\ServiceProvider;

class NeofeederServiceProvider extends ServiceProvider
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
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'neo');
        // Publish the package's public assets to the application's public folder
        $this->publishes([
            __DIR__.'/public' => public_path('aseplab/neofeeder'),
        ], 'public');
    }
}

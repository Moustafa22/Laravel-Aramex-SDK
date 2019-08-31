<?php

namespace Octw\Aramex;

use Illuminate\Support\ServiceProvider;

class AramexServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // publishing main Class in the package
        $this->app->make('Octw\Aramex\Aramex');
        
        // // merging config file
        // $this->mergeConfigFrom(
        //     __DIR__ . '/config/main.php', 'aramex'
        // );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // publishing config files
        $this->publishes([
            __DIR__ . '/config/main.php' => config_path('aramex.php'),
        ]);

    }
}

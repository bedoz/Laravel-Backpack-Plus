<?php
namespace Bedoz\BackpackPlus;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class BackpackPlusServiceProvider extends ServiceProvider {
    protected $commands = [

    ];

    // Indicates if loading of the provider is deferred.
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        \DB::statement("SET lc_time_names = 'it_IT'");
        Schema::defaultStringLength(191);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

    }
}

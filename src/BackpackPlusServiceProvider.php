<?php
namespace Bedoz\BackpackPlus;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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

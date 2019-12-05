<?php
namespace Bedoz\BackpackPlus;

use Bedoz\BackpackPlus\app\Library\CrudPanel\CrudPanel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class BackpackPlusServiceProvider extends ServiceProvider {
    protected $commands = [
        \Bedoz\BackpackPlus\app\Console\Commands\Install::class,
        \Bedoz\BackpackPlus\app\Console\Commands\CrudBackpackCommand::class,
        \Bedoz\BackpackPlus\app\Console\Commands\ViewBackpackCommand::class,
        \Bedoz\BackpackPlus\app\Console\Commands\ModelBackpackCommand::class,
        \Bedoz\BackpackPlus\app\Console\Commands\ConfigBackpackCommand::class,
        \Bedoz\BackpackPlus\app\Console\Commands\RequestBackpackCommand::class,
        \Bedoz\BackpackPlus\app\Console\Commands\CrudModelBackpackCommand::class,
        \Bedoz\BackpackPlus\app\Console\Commands\CrudRequestBackpackCommand::class,
        \Bedoz\BackpackPlus\app\Console\Commands\CrudOperationBackpackCommand::class,
        \Bedoz\BackpackPlus\app\Console\Commands\CrudControllerBackpackCommand::class,
    ];

    // Indicates if loading of the provider is deferred.
    protected $defer = false;

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the CrudPanel object to Laravel's service container
        $this->app->singleton('crud', function ($app) {
            return new \Bedoz\BackpackPlus\app\Library\CrudPanel\CrudPanel($app);
        });

        // register the artisan commands
        $this->commands($this->commands);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        \DB::statement("SET lc_time_names = 'it_IT'");
        Schema::defaultStringLength(191);

        $middleware_key = config('backpack.base.middleware_key');
        $this->app->router->pushMiddlewareToGroup($middleware_key, \Bedoz\BackpackPlus\app\Http\Middleware\AdminMiddleware::class);
    }
}

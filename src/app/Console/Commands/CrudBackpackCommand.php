<?php

namespace Bedoz\BackpackPlus\app\Console\Commands;

use Artisan;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class CrudBackpackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack-plus:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD interface: Controller, Model, Request';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $lowerName = strtolower($this->argument('name'));

        // Create the CRUD Controller and show output
        Artisan::call('backpack-plus:crud-controller', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Model and show output
        Artisan::call('backpack-plus:crud-model', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Request and show output
        Artisan::call('backpack-plus:crud-request', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD route
        Artisan::call('backpack-plus:add-custom-route', [
            'code' => "Route::crud('".$lowerName."', '".$name."CrudController');",
        ]);
        echo Artisan::output();

        // Create the sidebar item
        Artisan::call('backpack-plus:add-sidebar-content', [
            'code' => "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('".$lowerName."') }}'><i class='nav-icon fa fa-question'></i> ".Str::plural($name).'</a></li>',
        ]);
        echo Artisan::output();
    }
}
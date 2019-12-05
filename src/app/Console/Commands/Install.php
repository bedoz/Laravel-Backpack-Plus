<?php

namespace Bedoz\BackpackPlus\app\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Install extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "backpack-plus:install";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Backpack & BackPack Plus requirements on dev, publish files and create uploads directory, create user and roles.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //install backpack
        $this->call('backpack:install', ['--elfinder' => 'yes']);
        if ($this->confirm('Do you want to create basic Admin role?')) {
            //create roles and permissions
            $role = Role::create(['name' => 'Administrator']);
            $permission = Permission::create(['name' => 'access backend']);
            $role->givePermissionTo($permission);
        }
        if ($this->confirm('Do you want to create basic Admin user?')) {
            $email = $this->ask('What is his email address?');
            //create user
            $this->call('backpack:user', ['--email' => $email]);
            //assign role to new user
            $auth = config('backpack.base.user_model_fqn', 'App\User');
            $user = $auth::where('email', $email)->first();
            $user->assignRole('Administrator');
        }
    }
}

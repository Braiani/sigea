<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use TCG\Voyager\Models\MenuItem;
use App\Policies\MenuItemPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Task' => 'App\Policies\TaskPolicy',
        MenuItem::class => MenuItemPolicy::class,
        'App\Models\Registro' => 'App\Policies\RegistroRematriculaPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-actions', function ($user) {
            return $user->isAdmin;
        });
    }
}

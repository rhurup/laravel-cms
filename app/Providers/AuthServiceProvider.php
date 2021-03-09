<?php

namespace App\Providers;

use App\Models\Acl\AclPermission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        // Load all permissions and define them as Gates
        if (!app()->runningInConsole()) {
            collect(AclPermission::all())->each(function ($permission) {
                $ability = strtolower($permission->group . '.' . $permission->key);

                Gate::define($ability, function ($user) use ($permission) {
                    return $user->hasPermission($permission->key, $permission->group);
                });
            });
        }
    }
}

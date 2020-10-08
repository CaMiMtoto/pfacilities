<?php

namespace App\Providers;

use App\Roles;
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

        Gate::define("view-dashboard", function () {
            return in_array(auth()->user()->role, Roles::roles());
        });
        Gate::define("approve-applications", function () {
            return in_array(auth()->user()->role, collect(Roles::roles())->reject(function ($data) {
                return $data == Roles::$PARTNER;
            })->toArray());
        });
        Gate::define("view-reports", function () {
            return in_array(auth()->user()->role, [Roles::$ADMIN, Roles::$PARTNER]);
        });

        Gate::define("manage-settings", function () {
            return in_array(auth()->user()->role, [Roles::$ADMIN, Roles::$PHF]);
        });

        Gate::define("manage-users", function () {
            return in_array(auth()->user()->role, [Roles::$ADMIN]);
        });

        Gate::define("view-district-reports", function () {
            return true;
        });


    }
}

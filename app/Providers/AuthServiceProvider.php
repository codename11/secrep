<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Vehicle' => 'App\Policies\VehiclePolicy',
        'App\WorkOrganization' => 'App\Policies\WorkOrganizationPolicy',
        'App\Delivery' => 'App\Policies\DeliveryPolicy',
        'App\Special_Permission' => 'App\Policies\Special_PermissionPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}

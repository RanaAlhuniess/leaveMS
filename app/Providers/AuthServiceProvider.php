<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
//        Passport::routes();
        // Mandatory to define Scope
        Passport::tokensCan([
            'super-admin' => 'Can create all types of users, edit all user\'s info, and delete all types of users',
            'hr' => 'Can approve or decline leave requests, change leave balance for all employees, and manage leave types',
            'employee' => 'Can request leave with specific type and view leave history',
        ]);

        Passport::setDefaultScope([
            'employee'
        ]);

    }
}

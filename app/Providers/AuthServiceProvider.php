<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* define a admin user role */
        Gate::define('isAdmin', function($user) {
            return $user->userType->name == 'admin';
        });

        /* define a librarian user role */
        Gate::define('isLibrarian', function($user) {
            return $user->userType->name == 'librarian';
        });

        /* define a user role */
        Gate::define('isStudent', function($user) {
            return $user->userType->name == 'student';
        });

        Gate::define('isMyAccount', function($user, $profileUser) {
            return $user->id === $profileUser->id;
        });

    }
}

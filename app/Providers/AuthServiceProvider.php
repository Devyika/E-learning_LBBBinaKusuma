<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

    Gate::define('isAdmin', function ($user) {
        return $user->level_user == 0;
    });

    Gate::define('isGuru', function ($user) {
        return $user->level_user == 1;
    });

    Gate::define('isSiswa', function ($user) {
        return $user->level_user == 2;
    });
}

}

<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Modules\Admin\Entity\Admin;
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
     */
    public function boot(): void
    {
        Gate::before(function (Admin $user) {
            return $user->isAdmin() || $user->isChief();
        });


        $this->registerPolicies();

        //
    }
}

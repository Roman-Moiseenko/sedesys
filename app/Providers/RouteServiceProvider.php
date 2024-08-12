<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        $this->mapModulesRoutesAdmin();
        $this->mapModulesRoutesWeb();
        $this->mapModulesRoutesApi();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapModulesRoutesWeb()
    {
        modules_callback('routes_web.php', function($routesPath, $module) {
            Route::middleware(['web'])
                ->as('web.')
                ->namespace("\\App\\Modules\\$module\Controllers")
                ->group($routesPath);
        });
    }

    protected function mapModulesRoutesAdmin()
    {
        modules_callback('routes_admin.php', function($routesPath, $module) {
            Route::prefix('admin')
                ->middleware(['web', 'auth:admin'])
                ->as('admin.')
                ->namespace("\\App\\Modules\\$module\\Controllers")
                ->group($routesPath);
        });
    }

    protected function mapModulesRoutesApi()
    {
        modules_callback('routes_api.php', function($routesPath, $module) {
            Route::middleware(['web'])
                ->as('api.')
                ->namespace("\\App\\Modules\\$module\Controllers")
                ->group($routesPath);
        });
    }
}

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

        $this->mapModulesRoutesAPI();
        $this->mapModulesRoutesWeb();
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
        $modules_folder = app_path('Modules');
        $modules = $this->getModulesList($modules_folder);

        foreach ($modules as $module) {
            $routesPath = $modules_folder . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'routes_web.php';

            if (file_exists($routesPath)) {
                Route::prefix('web')
                    ->middleware(['web'])
                    ->namespace("\\App\\Modules\\$module\Controllers")
                    ->group($routesPath);
            }
        }
    }


    protected function mapModulesRoutesAPI()
    {
        $modules_folder = app_path('Modules');
        $modules = $this->getModulesList($modules_folder);

        foreach ($modules as $module) {
            $routesPath = $modules_folder . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'routes_api.php';

            if (file_exists($routesPath)) {
                Route::prefix('api')
                    ->middleware(['api'])
                    ->as('api.')
                    ->namespace("\\App\\Modules\\$module\Controllers")
                    ->group($routesPath);
            }
        }
    }

    private function getModulesList(string $modules_folder): array
    {
        return
            array_values(
                array_filter(
                    scandir($modules_folder),
                    function ($item) use ($modules_folder) {
                        return is_dir($modules_folder . DIRECTORY_SEPARATOR . $item) && !in_array($item, ['.', '..']);
                    }
                )
            );
    }
}

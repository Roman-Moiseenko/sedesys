<?php
declare(strict_types=1);

namespace App\Providers;
use App\View\WebComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        View::composer('*', WebComposer::class);
    }
}

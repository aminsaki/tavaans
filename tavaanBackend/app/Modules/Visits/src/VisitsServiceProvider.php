<?php

namespace holoo\modules\Visits;

use holoo\modules\Authentications\Middleware\PhoneThrottle;
use holoo\modules\Visits\Repositories\ConfigInteface;
use holoo\modules\Visits\Repositories\VisitInteface;
use holoo\modules\Visits\Repositories\VisitsRepositories;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class VisitsServiceProvider extends ServiceProvider
{
    /**
     * Make Config punishment optional by merging the Config from the package.
     */

    public function register(): void
    {
        $this->app->bind(
            VisitInteface::class,
            VisitsRepositories::class
        );
    }

    /**
     * Publishes configuration file.
     */
    public function boot(): void
    {

        $this->getMigrationsFrom();
        $this->routeRegister();
        Route::aliasMiddleware('phone.throttle', PhoneThrottle::class);
    }

    protected function routeRegister(): void
    {
        Route::prefix('api/v1')
            ->group(__DIR__ . '/routes/api.php');
    }

    protected function getMigrationsFrom(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../databases/migrations');
    }
}

<?php

namespace holoo\modules\Authentications;


use App\Modules\Authentications\src\Repositories\AuthsInterface;
use App\Modules\Authentications\src\Repositories\AuthsRepository;
use holoo\modules\Authentications\Middleware\PhoneThrottle;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class AuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Make config punishment optional by merging the config from the package.
     */
    public function register(): void
    {

        $this->app->bind(AuthsInterface::class, AuthsRepository::class);
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
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}

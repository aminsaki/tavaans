<?php

namespace holoo\modules\Bases;

use App\Modules\Bases\src\servers\bank\Gateway\ZarinPal;
use holoo\modules\Bases\Http\Contracts\BaseRepository;
use holoo\modules\Bases\Http\Contracts\BaseRepositoryInterface;
use holoo\modules\Bases\servers\bank\PaymentGatewayInterface;
use holoo\modules\Bases\servers\sms\adapter\Kavenegars\Kavenegar;
use holoo\modules\Bases\servers\sms\adapter\mediana\MedianaSmsGateway;
use holoo\modules\Bases\servers\sms\adapter\parsgreen\Sms;
use holoo\modules\Bases\servers\sms\adapter\SmsGateway;
use holoo\modules\Bases\servers\sms\SmsInterface;
use holoo\modules\Bases\servers\webServers\adpter\ClientWordPress;
use holoo\modules\Bases\servers\webServers\ClientWordPressInterface;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Publishes configuration file.
     */
    public function boot(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(SmsGateway::class, MedianaSmsGateway::class);

    }

    /**
     * Make Config punishment optional by merging the Config from the package.
     */
    public
    function register(): void
    {
    }
}

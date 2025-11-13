<?php

namespace holoo\modules\Bases;

use App\Modules\Bases\src\servers\bank\Gateway\ZarinPal;
use holoo\modules\Bases\Http\Contracts\BaseRepository;
use holoo\modules\Bases\Http\Contracts\BaseRepositoryInterface;
use holoo\modules\Bases\servers\bank\PaymentGatewayInterface;
use holoo\modules\Bases\servers\sms\adapter\Kavenegars\Kavenegar;
use holoo\modules\Bases\servers\sms\adapter\parsgreen\Sms;
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
        $this->app->bind(SmsInterface::class, Sms::class);
        $this->app->bind(PaymentGatewayInterface::class , ZarinPal::class);
        $this->app->bind(ClientWordPressInterface::class , ClientWordPress::class);
    }
    /**
     * Make config punishment optional by merging the config from the package.
     */
    public
    function register(): void
    {
    }
}

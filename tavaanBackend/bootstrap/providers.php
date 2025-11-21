<?php
use holoo\modules as modules;
return [
    App\Providers\AppServiceProvider::class,
    modules\Bases\BaseServiceProvider::class,
    modules\Authentications\AuthenticationServiceProvider::class,
    modules\Config\ConfigServiceProvider::class,
    modules\Visits\visitsServiceProvider::class,

];

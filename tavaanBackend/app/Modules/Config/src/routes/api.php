<?php

use Illuminate\Support\Facades\Route;
use  holoo\modules\Config\Https\Controllers as Controller;

Route::middleware('auth:api')->group(function () {

    Route::apiResource('configs', Controller\ConfigController::class);
});

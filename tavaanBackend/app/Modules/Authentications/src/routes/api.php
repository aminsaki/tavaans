<?php

use holoo\modules\Authentications\Http\Controllers as Controllers;
use \Illuminate\Support\Facades\Route;


Route::apiResource('authentications', Controllers\OtpController::class);



<?php

use Illuminate\Support\Facades\Route;
use  holoo\modules\Visits\Https\Controllers as Controller;

Route::middleware('auth:api')->group(function () {
Route::apiResource('visits', Controller\VisitController::class);
Route::post('serachVisits', [Controller\VisitController::class, 'serachVisits']);
Route::post('updateVisits', [Controller\VisitController::class, 'updateVisits']);
Route::post('visits/export-excel', [Controller\VisitController::class, 'exportExcel']);

});

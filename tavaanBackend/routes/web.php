<?php

use Illuminate\Support\Facades\Route;

Route::get('/passwords', function () {
      dd(\Illuminate\Support\Facades\Hash::make('password'));
});

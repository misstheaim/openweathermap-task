<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OWPDataReceiveController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check', OWPDataReceiveController::class);

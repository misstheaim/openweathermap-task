<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(APIController::class)->group(function () {
    Route::get('/cities', 'getCities');
    Route::get('/weather/{city}', 'getHistoricalInfo');
    Route::get('/weather/{city}/latest', 'getLatestInfo');
    Route::get('/weather', 'getAllInfo');
});

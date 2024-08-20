<?php

use App\Http\Controllers\Api\V1\GuestController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::apiResource('guests', GuestController::class);
});

Route::get('/log-test', function () {
    Log::channel('redis')->info('Test log entry', ['test' => 'value']);
    return 'Log entry created';
});

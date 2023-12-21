<?php

use App\Http\Controllers\Api\v1\ApiController\ApiController;
use App\Http\Controllers\Api\v2\Utility\ApiProfileController;
use App\Http\Controllers\Api\v2\Utility\UtilityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('app')->middleware(['app'])->group(function () {
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        
    });
});

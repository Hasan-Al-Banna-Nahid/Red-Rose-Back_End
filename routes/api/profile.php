<?php

use App\Http\Controllers\Api\v1\ApiController\ApiController;
use App\Http\Controllers\Api\v2\Utility\ApiProfileController;
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
        Route::prefix('profile')->group(function () {
            Route::get('public/{id}', [ApiProfileController::class, 'public_profile']);
            Route::get('my', [ApiProfileController::class, 'my_profile']);
        });
        Route::prefix('update')->group(function () {
            Route::post('info', [ApiProfileController::class, 'update_info']);
            Route::post('profile', [ApiProfileController::class, 'update_profile']);
            Route::post('social', [ApiProfileController::class, 'update_social_profile']);
        });
    });
});

<?php

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

	Route::get('/blogs', [UtilityController::class, 'all_blog']);
	Route::get('/blog/{id}', [UtilityController::class, 'blog_item']);

	Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function (){
        Route::get('/all-class', [UtilityController::class, 'all_class']);
        Route::get('/all-country', [UtilityController::class, 'all_country']);
        Route::get('/division/{id}', [UtilityController::class, 'division']);
        Route::get('/city/{id}', [UtilityController::class, 'city']);
        Route::get('/upazila/{id}', [UtilityController::class, 'upazila']);
    });
});

<?php

use App\Http\Controllers\Api\v2\Utility\ApiEventController;
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
        Route::prefix('event')->group(function () {
            Route::get('all', [ApiEventController::class, 'all_event']);
            Route::get('my', [ApiEventController::class, 'my_events']);
            Route::post('enroll', [ApiEventController::class, 'event_enroll']);
            Route::get('syllabus/{id}', [ApiEventController::class, 'event_syllabus']);
            Route::get('participant/{id}', [ApiEventController::class, 'event_participant']);
            Route::get('take-exam/{id}', [ApiEventController::class, 'event_take_exam']);
            Route::post('submit-exam-for-result', [ApiEventController::class, 'event_submit_exam_for_result']);
            Route::get('get-result/{id}', [ApiEventController::class, 'event_get_result']);
        });
    });
});

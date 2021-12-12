<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseRowController;
use App\Http\Controllers\FetchFromSheetsController;
use App\Http\Controllers\TrainingDayController;
use App\Http\Controllers\TrainingPeriodController;
use App\Http\Controllers\TrainingSetController;
use Illuminate\Http\Request;
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

Route::get('/login/', [AuthController::class, 'redirectToProvider'])->name('login');
Route::get('login/google/callback', [AuthController::class, 'handleProviderCallback']);

Route::middleware(['auth:sanctum'])->group( function () {
    Route::apiResource('exercises', ExerciseController::class);
    Route::get('training_periods/fetch', FetchFromSheetsController::class);
    Route::apiResource('training_periods', TrainingPeriodController::class);
    Route::apiResource('training_days', TrainingDayController::class);
});


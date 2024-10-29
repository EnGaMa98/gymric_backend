<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseRingController;
use App\Http\Controllers\GoalController;

//User

Route::prefix('user')->group(function () {
    Route::get('/get', [AuthController::class, 'index'])->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->put('/update', [AuthController::class, 'updateUser']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//exercise_rings
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('exercise-rings')->group(function () {
        Route::get('/', [ExerciseRingController::class, 'index']);
        Route::post('/new', [ExerciseRingController::class, 'store']);

        Route::prefix('/{exerciseRing}')->group(function () {
            Route::get('/', [ExerciseRingController::class, 'index']);
            Route::post('/', [ExerciseRingController::class, 'store']);
            Route::delete('/', [ExerciseRingController::class, 'destroy']);
        });
    });

    Route::prefix('goals')->group(function () {
        Route::get('/', [GoalController::class, 'index']);
        Route::post('/new', [GoalController::class, 'store']);

        Route::prefix('/{goal}')->group(function () {
            Route::get('/', [GoalController::class, 'index']);
        });
    });
    
});

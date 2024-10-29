<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseRingController;
use App\Http\Controllers\GoalController;

//User

Route::prefix('users')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::prefix('/{user}')->group(function () {
            Route::where(['user' => 'me'])->group(function () {
                Route::get('/', [AuthController::class, 'index']);
                Route::post('/', [AuthController::class, 'store']);
                Route::post('/logout', [AuthController::class, 'logout']);
            });
        });
    });

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

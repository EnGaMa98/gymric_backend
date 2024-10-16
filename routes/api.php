<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseRingController;
use App\Http\Controllers\GoalController;

//User
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//exercise_rings
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('exercise-rings')->group(function () {
        Route::get('/', [ExerciseRingController::class, 'index']);
        Route::get('/{exerciseRing}', [ExerciseRingController::class, 'index']);
        Route::post('/new', [ExerciseRingController::class, 'store']);
        Route::post('/{exerciseRing}', [ExerciseRingController::class, 'store']);
        Route::delete('/{exerciseRing}', [ExerciseRingController::class, 'destroy']);
    });

    //Goals
    Route::get('goals', [GoalController::class, 'index']);
    Route::put('goals/{id}', [GoalController::class, 'update']);

    //logout d'usuari
    Route::post('logout', [AuthController::class, 'logout']);
});

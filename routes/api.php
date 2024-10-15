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
    Route::get('exercise-rings', [ExerciseRingController::class, 'index']);
    Route::post('exercise-rings', [ExerciseRingController::class, 'store']);
    Route::put('exercise-rings/{id}', [ExerciseRingController::class, 'update']);
    Route::delete('exercise-rings/{id}', [ExerciseRingController::class, 'destroy']);

    //Goals
    Route::get('goals', [GoalController::class, 'index']); // Obtener el goal del usuario
    Route::put('goals/{id}', [GoalController::class, 'update']); // Actualizar el goal del usuario
});
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExerciseRing;
use Illuminate\Support\Facades\Auth;

class ExerciseRingController extends Controller
{
    // Guardar los datos de los anillos de ejercicio
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'move_goal' => 'required|integer',
            'move_progress' => 'required|integer',
            'exercise_goal' => 'required|integer',
            'exercise_progress' => 'required|integer',
            'stand_goal' => 'required|integer',
            'stand_progress' => 'required|integer',
            'date' => 'required|date|unique:exercise_rings,date,user_id,' . Auth::id(),
        ]);

        // Crear el registro en la base de datos
        $exerciseRing = ExerciseRing::create([
            'user_id' => Auth::id(), // El ID del usuario autenticado
            'move_goal' => $request->move_goal,
            'move_progress' => $request->move_progress,
            'exercise_goal' => $request->exercise_goal,
            'exercise_progress' => $request->exercise_progress,
            'stand_goal' => $request->stand_goal,
            'stand_progress' => $request->stand_progress,
            'date' => $request->date,
        ]);

        return response()->json($exerciseRing, 201); // Retorna el registro creado
    }

    // Obtener los datos de ejercicio del usuario
    public function index()
    {
        $userId = Auth::id();
        $exerciseRings = ExerciseRing::where('user_id', $userId)->orderBy('date', 'desc')->get();

        return response()->json($exerciseRings);
    }
}
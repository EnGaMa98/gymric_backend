<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExerciseRing;
use Illuminate\Support\Facades\Auth;

class ExerciseRingController extends Controller
{
    // llistar els exercise_rings
    public function index()
    {
        $userId = Auth::id();
        $exerciseRings = ExerciseRing::where('user_id', $userId)->orderBy('date', 'desc')->get();

        return response()->json($exerciseRings);
    }
    // Guardar les dades dels anells d'usuari
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'move_progress' => 'required|integer',
            'exercise_progress' => 'required|integer',
            'stand_progress' => 'required|integer',
            'date' => 'required|date|unique:exercise_rings,date,user_id,' . Auth::id(),
        ]);

        // Crear el registro en la base de datos
        $exerciseRing = ExerciseRing::create([
            'user_id' => Auth::id(), // El ID del usuario autenticado
            'move_progress' => $request->move_progress,
            'exercise_progress' => $request->exercise_progress,
            'stand_progress' => $request->stand_progress,
            'date' => $request->date,
        ]);

        return response()->json($exerciseRing, 201); // Retorna el registro creado
    }

    //modificar un exercise_ring
    public function update(Request $request, $id)
    {
        $request->validate([
            'move_progress' => 'sometimes|required|integer',
            'exercise_progress' => 'sometimes|required|integer',
            'stand_progress' => 'sometimes|required|integer',
            'date' => 'sometimes|required|date',
        ]);

        $exerciseRing = ExerciseRing::findOrFail($id);

        // Verificar que el ejercicio pertenece al usuario autenticado
        if ($exerciseRing->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Actualizar solo los campos que se han proporcionado
        $exerciseRing->update($request->all());

        return response()->json($exerciseRing, 200);
    }
    //Eliminar un exercise_ring
    public function destroy($id)
    {
        $exerciseRing = ExerciseRing::findOrFail($id);

        // Verificar que el ejercicio pertenece al usuario autenticado
        if ($exerciseRing->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $exerciseRing->delete();

        return response()->json(['message' => 'Exercise ring deleted successfully'], 200);
    }
    
}
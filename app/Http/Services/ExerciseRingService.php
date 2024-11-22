<?php

namespace App\Http\Services;

use App\Http\Resources\ExerciseRingResource;
use App\Models\ExerciseRing;
use App\Models\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExerciseRingService extends BaseService
{

    public function getModel(): string
    {
        return ExerciseRing::class;
    }

    public function index(ExerciseRing $exerciseRing): JsonResponse
    {
        $query = ExerciseRing::query();

        // Eager vs lazy loading (Eager loading)
        $query->with('user');
        $query->with('goal');

        if ($exerciseRing->exists) {
            $query->where('id', $exerciseRing->id);
            $data = new ExerciseRingResource($query->first());
        } else {
            $query->orderBy('date', 'desc');
            $data = ExerciseRingResource::collection($query->get());
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    // Guardar les dades dels anells d'usuari
    public function store(ExerciseRing $exerciseRing, Request $request): JsonResponse
    {
        // Validar los datos de la solicitud
        $request->validate([
            'move_progress'     => 'required|integer',
            'exercise_progress' => 'required|integer',
            'stand_progress'    => 'required|integer',
            'date'              => 'required|date',
        ]);

        if (!$exerciseRing->exists) {
            $exerciseRing->user_id = Auth::id();
        }

        $activeGoal = Goal::query()->where('isActive', true)->first();

        $exerciseRing->goal_id           = $activeGoal->id ?? null;
        $exerciseRing->move_progress     = $request->move_progress;
        $exerciseRing->exercise_progress = $request->exercise_progress;
        $exerciseRing->stand_progress    = $request->stand_progress;
        $exerciseRing->date              = $request->date;

        $exerciseRing->save();

        return response()->json(new ExerciseRingResource($exerciseRing), $exerciseRing->wasRecentlyCreated ? Response::HTTP_CREATED : Response::HTTP_OK); // Retorna el registro creado
    }

    //Eliminar un exercise_ring
    public function destroy(ExerciseRing $exerciseRing): JsonResponse
    {
        $exerciseRing->delete();

        return response()->json(['message' => 'Exercise ring deleted successfully']);
    }

}

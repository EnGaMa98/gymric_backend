<?php

namespace App\Http\Services;

use App\Http\Resources\GoalResource;
use App\Models\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GoalService extends BaseService
{

    public function getModel(): string
    {
        return Goal::class;
    }

    public function index(array $include = [], array $filter = []): JsonResponse
    {
        $goals = Goal::all();
        return response()->json($goals);
    }
    // Crear o actualitzar goal
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'move_goal' => 'required|integer',
            'exercise_goal' => 'required|integer',
            'stand_goal' => 'required|integer',
        ]);

        // Obtenir la meta actual
        $goal = Goal::where('user_id', $request->user()->id)->first();

        if ($goal) {
            // Si existeix, s'actualitza
            $goal->update($request->all());
            return response()->json($goal);
        } else {
            // Si no existeix, es crea una de nova
            $goal = Goal::create(array_merge($request->all(), ['user_id' => $request->user()->id]));
            return response()->json($goal, 201);
        }
    }

}

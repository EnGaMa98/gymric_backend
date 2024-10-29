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

    public function index(Goal $goal): JsonResponse
    {
        $query = Goal::query();
        if ($goal->exists) {
            $query->where('id', $goal->id);
            $data = new GoalResource($query->first());
        } else {
            $query->orderBy('id', 'desc');
            $data = GoalResource::collection($query->get());
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Goal $goal, Request $request): JsonResponse
    {
        $request->validate([
            'move_goal'     => 'required|integer',
            'exercise_goal' => 'required|integer',
            'stand_goal'    => 'required|integer',
        ]);

        if (!$goal->exists) {
            Goal::where('user_id', Auth::id())->update(['isActive' => false]);

            $goal->user_id  = Auth::id();
            $goal->isActive = true;
        }

        $goal->move_goal     = $request->move_goal;
        $goal->exercise_goal = $request->exercise_goal;
        $goal->stand_goal    = $request->stand_goal;

        $goal->save();

        if ($goal->wasRecentlyCreated) {
            Auth::user()->update([
                'goal_id' => $goal->id,
            ]);
        }

        return response()->json(new GoalResource($goal), Response::HTTP_OK);
    }

}

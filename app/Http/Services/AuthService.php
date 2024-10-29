<?php

namespace App\Http\Services;

use App\Http\Resources\GoalResource;
use App\Http\Resources\UserResource;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthService extends BaseService
{

    public function getModel(): string
    {
        return User::class;
    }

    public function index(User $user): JsonResponse
    {
        $query = User::query();

        $query->with('exerciseRings.goal');

        $query->with('goals');

        $query->with('goal');

        if ($user->exists) {
            $query->where('id', $user->id);
            $data = new UserResource($query->first());
        } else {
            $query->orderBy('id', 'desc');
            $data = UserResource::collection($query->get());
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
            $goal->user_id = Auth::id();
        }


        Goal::where('user_id', Auth::id())->update(['isActive' => false]);


        $goal->move_goal     = $request->move_goal;
        $goal->exercise_goal = $request->exercise_goal;
        $goal->stand_goal    = $request->stand_goal;
        $goal->isActive      = true;

        $goal->save();

        return response()->json(new GoalResource($goal), Response::HTTP_OK);
    }

}

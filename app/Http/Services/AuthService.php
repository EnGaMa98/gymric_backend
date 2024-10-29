<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function store(User $user, Request $request): JsonResponse
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'required|in:hombre,mujer',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
        ]);

        $user->name   = $request->name;
        $user->email  = $request->email;
        $user->gender = $request->gender;
        $user->height = $request->height;
        $user->weight = $request->weight;

        $user->save();

        return response()->json(new UserResource($user), Response::HTTP_OK);
    }

}
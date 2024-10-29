<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ExerciseRingResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function index(): JsonResponse
    {
        $user = Auth::user();
        $userData = [
            'name'   => $user->name,
            'email'  => $user->email,
            'gender' => $user->gender,
            'height' => $user->height,
            'weight' => $user->weight,
        ];

        $exerciseRingsQuery = $user->exerciseRings()->with('goal')->orderBy('created_at', 'desc');
        $exerciseRingsData = ExerciseRingResource::collection(resource: $exerciseRingsQuery->get());

        return response()->json([
            'message' => 'Datos del usuario obtenidos correctamente',
            'user' => $userData,
            'exerciseRings' => $exerciseRingsData,
        ], 200);
    }
    // Registro
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender'   => 'nullable|in:hombre,mujer',
            'height'   => 'nullable|numeric',
            'weight'   => 'nullable|numeric',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'gender'   => $request->gender,
            'height'   => $request->height,
            'weight'   => $request->weight,
        ]);

        $token= $user->createToken('app')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token= $user->createToken('app')->plainTextToken;
        return response()->json(['token' => $token], 201);
    }

    public function updateUser(Request $request): JsonResponse
    {
 
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'sometimes|in:hombre,mujer',
            'height' => 'sometimes|numeric',
            'weight' => 'sometimes|numeric',
        ]);
        $updated = $user->update($request->only(['name', 'email', 'gender', 'height', 'weight']));

        if (!$updated) {
            return response()->json(['message' => 'No se pudo actualizar el usuario'], 500);
        }


        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'user' => $user
        ], 200);
    }
    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['message' => 'No user is authenticated'], 401);
    }
}
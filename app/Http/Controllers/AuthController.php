<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function index(User $user): JsonResponse
    {
        return $this->service->index($user);
    }

    public function store(User $user, Request $request): JsonResponse
    {
        return $this->service->store($user, $request);
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

        $token = $user->createToken('app')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('app')->plainTextToken;
        return response()->json(['token' => $token], 201);
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

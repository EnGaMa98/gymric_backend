<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;



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

    public function register(Request $request): JsonResponse
    {
        return $this->service->register($request);
    }

    public function login(Request $request): JsonResponse
    {
        return $this->service->login($request);
    }

    public function logout(): JsonResponse
    {
        return $this->service->logout();
    }
}

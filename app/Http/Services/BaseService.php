<?php

namespace App\Http\Services;

use Illuminate\Http\JsonResponse;

abstract class BaseService
{
    public abstract function getModel(): string;

    public abstract function index(array $include = [], array $filter = []): JsonResponse;
}

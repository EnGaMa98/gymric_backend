<?php

namespace App\Http\Controllers;
use App\Http\Services\GoalService;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends BaseController
{
    
    public function __construct()
    {
        $this->service = new GoalService();
    }

    public function index(Goal $goal)
    {
        return $this->service->index($goal);
    }

    public function store (Goal $goal, request $request)
    {
      $this->service->store($goal, $request);
    }
}

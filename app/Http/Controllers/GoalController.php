<?php

namespace App\Http\Controllers;
use App\Http\Services\GoalService;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends BaseController
{
    //Listar las metas
    public function __construct()
    {
        $this->service = new GoalService();
    }

    public function index(Goal $goal)
    {
        return $this->service->index();
    }

  public function store (Goal $goal, request $request)
  {
    $this->service->store(Goal: $goal, $request);
  }
}

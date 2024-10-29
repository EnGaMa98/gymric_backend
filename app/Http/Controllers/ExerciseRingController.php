<?php

namespace App\Http\Controllers;

use App\Http\Services\ExerciseRingService;
use App\Models\ExerciseRing;
use Illuminate\Http\Request;

class ExerciseRingController extends BaseController
{

    public function __construct()
    {
        $this->service = new ExerciseRingService();
    }

    public function index(ExerciseRing $exerciseRing)
    {
        return $this->service->index($exerciseRing);
    }

    public function store(ExerciseRing $exerciseRing, Request $request)
    {
        //var_dump($exerciseRing->exists);
        //die;
        return $this->service->store($exerciseRing, $request);
    }

    public function destroy(ExerciseRing $exerciseRing)
    {
        return $this->service->destroy($exerciseRing);
    }

}

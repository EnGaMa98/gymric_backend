<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $result = [
            'id'     => $this->id,
            'fields' => [
                'move_goal'     => $this->move_goal,
                'exercise_goal' => $this->exercise_goal,
                'stand_goal'    => $this->stand_goal,
            ],
        ];

        return $result;
    }
}

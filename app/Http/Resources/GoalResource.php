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
                'value' => [
                    'move'     => $this->move_goal,
                    'exercise' => $this->exercise_goal,
                    'stand'    => $this->stand_goal,
                ],
            ],
        ];

        return $result;
    }
}

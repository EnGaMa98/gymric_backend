<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseRingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $result = [
            'id'     => $this->id,
            'fields' => [
                'move_progress'     => $this->move_progress,
                'exercise_progress' => $this->exercise_progress,
                'stand_progress'    => $this->stand_progress,
                'date'              => $this->date,
            ],
        ];

        if ($this->relationLoaded('goal')) {
            $result['goal'] = new GoalResource($this->goal);
        }

        return $result;
    }
}

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
                'value' => [
                    'move'     => $this->move_progress,
                    'exercise' => $this->exercise_progress,
                    'stand'    => $this->stand_progress,
                ],
                'date'  => $this->date,
            ],
        ];

        if ($this->relationLoaded('goal')) {
            $result['fields']['progress'] = [
                'move'     => $this->progress('move'),
                'exercise' => $this->progress('exercise'),
                'stand'    => $this->progress('stand'),
            ];

            $result['goal'] = new GoalResource($this->goal);
        }

        return $result;
    }
}

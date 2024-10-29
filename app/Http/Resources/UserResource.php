<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $result = [
            'id'     => $this->id,
            'fields' => [
                'name'   => $this->name,
                'email'  => $this->email,
                'gender' => $this->gender,
                'height' => $this->height,
                'weight' => $this->weight,
            ],
        ];

        if ($this->relationLoaded('exerciseRings')) {
            $result['exercise_rings'] = ExerciseRingResource::collection($this->exerciseRings);
        }

        if ($this->relationLoaded('goals')) {
            $result['goals'] = GoalResource::collection($this->goals);
        }

        if ($this->relationLoaded('goal')) {
            $result['goal'] = new GoalResource($this->goal);
        }

        return $result;
    }
}

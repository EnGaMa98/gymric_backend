<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseRing extends Model
{
    use HasFactory;

    protected $fillable
        = [
            'user_id',
            'move_progress',
            'exercise_progress',
            'stand_progress',
            'date',
            'goal_id',
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    protected $fillable
        = [
            'user_id',
            'move_goal',
            'exercise_goal',
            'stand_goal',
            'created_at',
            'updated_at',
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

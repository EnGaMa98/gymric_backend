<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

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

    protected static function booted(): void
    {
        static::addGlobalScope(function (Builder $builder) {
            $builder->where('user_id', Auth::id());
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

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

    protected $casts
        = [
            'date' => 'date',
        ];

    protected static function booted(): void
    {
        static::addGlobalScope(function (Builder $builder) {
            $builder->where('user_id', Auth::id());
        });
    }

    public function progress(string $property): int
    {
        $value     = $this->{$property . '_progress'};
        $goalValue = $this->goal->{$property . '_goal'};

        if ($goalValue > 0) {
            return min(100, $value / $goalValue * 100);
        } else {
            return 0;
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}

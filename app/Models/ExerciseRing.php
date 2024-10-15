<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseRing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'move_progress',
        'exercise_progress',
        'stand_progress',
        'date',
    ];
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}

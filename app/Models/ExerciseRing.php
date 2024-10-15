<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseRing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'move_goal',
        'move_progress',
        'exercise_goal',
        'exercise_progress',
        'stand_goal',
        'stand_progress',
        'date',
    ];
}
//prova


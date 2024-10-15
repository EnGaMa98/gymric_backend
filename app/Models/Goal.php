<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'move_goal',
        'exercise_goal',
        'stand_goal',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


?>
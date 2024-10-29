<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable
        = [
            'name',
            'email',
            'password',
            'goal_id',
            'gender',
            'height',
            'weight',
        ];

    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    protected $casts
        = [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];

    public function exerciseRings(): HasMany
    {
        return $this->hasMany(ExerciseRing::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}

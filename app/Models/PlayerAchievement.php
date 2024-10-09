<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'achievement_id',
        'date_earned'
    ];

    protected $casts = [
        'date_earned' => 'datetime'
    ];

    public function playerAchievements()
    {
        return $this->belongsToMany(Achievement::class, 'player_achievements');
    }
}

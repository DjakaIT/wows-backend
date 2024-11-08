<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'battle_achievement',
        'progress_achievement'
    ];


    public function playerAchievements()
    {
        return $this->belongsToMany(Achievement::class, 'player_achievements');
    }
}

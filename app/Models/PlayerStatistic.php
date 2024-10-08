<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'battles_played',
        'wins',
        'damage_dealt',
        'avg_xp',
        'win_rate',
        'wn8'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }



    //method to calculate win ratios

    public function winRate()
    {
        return $this->battles_played > 0 ? ($this->wins / $this->battlles_played) * 100 : 0;
    }

    //method to calculate avg damage

    public function averageDamage()
    {
        return $this->battles_played > 0 ? round($this->damage_dealt / $this->battles_played) : 0;
    }

    //pull number of total battles played
    public function totalBattles()
    {
        return $this->battles_played->count();
    }
}

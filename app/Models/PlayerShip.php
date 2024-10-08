<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerShip extends Model
{
    use HasFactory;


    protected $fillable = [

        'player_id',
        'ship_id',
        'battles_count',
        'wins_count',
        'damage_dealt',
        'average_damage',
        'frags',
        'survival_rate'
    ];


    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }
}

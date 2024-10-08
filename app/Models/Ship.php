<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;


    protected $fillable = [

        'ship_id',
        'name',
        'tier',
        'type',
        'nation'
    ];


    public function player()
    {
        return $this->hasMany(PlayerShip::class);
    }

    public function Battle()
    {
        return $this->hasMany(BattleParticipant::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClanMember extends Model
{
    use HasFactory;

    protected $fillable = [

        'players_id',
        'clans_id',
        'joined_at',
        'left_at',
        'role'
    ];


    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function clan()
    {
        return $this->belongsTo(Clan::class, 'clans_id');
    }

    public function scopeByActive($query)
    {
        return $query->whereNull('left_at');
    }
}

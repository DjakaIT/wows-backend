<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_achievements');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    use HasFactory;

    protected $fillable = [
        'battle_id',
        'battle_date',
        'duration',
        'map_name',
        'battle_type'
    ];
}

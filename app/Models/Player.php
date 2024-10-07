<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory;

    protected $filable = [
        'nickname',
        'server',
        'account_id',
        'clan_id'
    ];

    //defines the relationship with Clan table
    public function clan()
    {
        return $this->BelongsTo(Clan::class);
    }
}

<?php

namespace App\Models;

class Player extends BaseModel
{
    protected $table = 'players';

    protected $fillable = [
        'discord_id',
        'highest_score',
        'sun_time',
    ];
}

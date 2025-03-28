<?php

namespace App\Models;
use App\Models\Player;

class GuildPlayer extends BaseModel
{
    protected $table = 'guild_player';

    protected $fillable = [
        'player_id',
        'guild_id',
        'last_played_at',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

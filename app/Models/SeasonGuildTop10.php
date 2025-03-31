<?php

namespace App\Models;
use App\Models\Player;
use App\Models\SeasonHistory;

class SeasonGuildTop10 extends BaseModel
{
    protected $table = 'season_guild_top10';

    protected $fillable = [
        'season_id',
        'guild_id',
        'player_id',
        'rank',
        'score',
        'sun_time',
    ];

    public function season()
    {
        return $this->belongsTo(SeasonHistory::class, 'season_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }
}

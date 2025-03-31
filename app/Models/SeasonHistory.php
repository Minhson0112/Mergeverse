<?php

namespace App\Models;
use App\Models\SeasonGlobalTop10;
use App\Models\SeasonGuildTop10;

class SeasonHistory extends BaseModel
{
    protected $table = 'season_histories';

    protected $fillable = [
        'start_at',
        'end_at',
    ];

    protected $appends = ['season_name'];

    public function getSeasonNameAttribute()
    {
        return 'Mùa ' . $this->id;
    }

    public function globalTop10()
    {
        return $this->hasMany(SeasonGlobalTop10::class, 'season_id');
    }

    public function guildTop10()
    {
        return $this->hasMany(SeasonGuildTop10::class, 'season_id');
    }
}

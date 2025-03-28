<?php

namespace App\Repository\GuildPlayer;

use App\Models\GuildPlayer;
use App\Repository\Base\BaseRepository;

class GuildPlayerRepository extends BaseRepository implements GuildPlayerRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return GuildPlayer::class;
    }
}

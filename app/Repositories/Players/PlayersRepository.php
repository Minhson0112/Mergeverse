<?php

namespace App\Repository\Players;

use App\Models\Player;
use App\Repository\Base\BaseRepository;

class PlayersRepository extends BaseRepository implements PlayersRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return Player::class;
    }
}

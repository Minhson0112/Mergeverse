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

    public function findByDiscordId(string $discordId)
    {
        return $this->model->where('discord_id', $discordId)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $player = $this->model->find($id);
        if ($player) {
            return $player->update($data);
        }
        return false;
    }
}

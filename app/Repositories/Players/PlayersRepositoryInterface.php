<?php

namespace App\Repository\Players;

interface PlayersRepositoryInterface
{
    public function getModel(): string;
    public function findByDiscordId(string $discordId);
    public function create(array $data);
    public function update(int $id, array $data);
}

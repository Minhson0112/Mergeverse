<?php

namespace App\Repository\GuildPlayer;

interface GuildPlayerRepositoryInterface
{
    public function getModel(): string;
    public function exists(int $playerId, string $guildId): bool;
    public function getPlayerIdsByGuildId(string $guildId): array;
    public function getAllGuildIds(): array;
}

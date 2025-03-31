<?php

namespace App\Repository\SeasonGuildTop10;

interface SeasonGuildTop10RepositoryInterface
{
    public function getModel(): string;
    public function getTop10BySeasonAndGuild(int $seasonId, string $guildId): array;
    public function existsBySeasonAndGuild(int $seasonId, string $guildId): bool;
}
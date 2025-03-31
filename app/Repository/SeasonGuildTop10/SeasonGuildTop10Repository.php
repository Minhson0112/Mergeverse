<?php

namespace App\Repository\SeasonGuildTop10;
use App\Repository\Base\BaseRepository;
use App\Models\SeasonGuildTop10;

class SeasonGuildTop10Repository extends BaseRepository implements SeasonGuildTop10RepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return SeasonGuildTop10::class;
    }

    public function getTop10BySeasonAndGuild(int $seasonId, string $guildId): array
    {
        return $this->model
            ->with('player:id,username') // chỉ lấy trường cần thiết
            ->where('season_id', $seasonId)
            ->where('guild_id', $guildId)
            ->orderBy('rank')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                return [
                    'username' => $row->player->username ?? 'Unknown',
                    'score' => $row->score,
                ];
            })
            ->toArray();
    }

    public function existsBySeasonAndGuild(int $seasonId, string $guildId): bool
    {
        return $this->model
            ->where('season_id', $seasonId)
            ->where('guild_id', $guildId)
            ->exists();
    }
}
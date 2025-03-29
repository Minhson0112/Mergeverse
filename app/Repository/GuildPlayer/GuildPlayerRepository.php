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

    public function exists(int $playerId, string $guildId): bool
    {
        return GuildPlayer::where('player_id', $playerId)
            ->where('guild_id', $guildId)
            ->exists();
    }

    public function getPlayerIdsByGuildId(string $guildId): array
    {
        return GuildPlayer::where('guild_id', $guildId)
            ->pluck('player_id')
            ->toArray();
    }

}

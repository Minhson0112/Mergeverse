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

    public function update(int $id, array $data)
    {
        $player = $this->model->find($id);
        if ($player) {
            return $player->update($data);
        }
        return false;
    }

    public function getTop10Players()
    {
        return $this->model
            ->select('username', 'highest_score as score')
            ->orderByDesc('highest_score')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function getRankByScore(int $score)
    {
        return $this->model
            ->where('highest_score', '>', $score)
            ->count() + 1;
    }

    public function getTop10PlayersByIds(array $ids)
    {
        return $this->model
            ->select('username', 'highest_score as score')
            ->whereIn('id', $ids)
            ->orderByDesc('highest_score')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function getRankInGroup(int $playerId, array $groupedPlayerIds)
    {
        $player = $this->model->find($playerId);
        if (!$player) return null;

        return $this->model
            ->whereIn('id', $groupedPlayerIds)
            ->where('highest_score', '>', $player->highest_score)
            ->count() + 1;
    }

    public function getTop10SunPlayers()
    {
        return $this->model
            ->whereNotNull('sun_time')
            ->orderBy('sun_time', 'asc')
            ->limit(10)
            ->get(['username', 'sun_time'])
            ->toArray();
    }

    public function getSunRankByTime($sunTime)
    {
        return $this->model
            ->whereNotNull('sun_time')
            ->where('sun_time', '<', $sunTime)
            ->count() + 1;
    }

    public function getFastestSunPlayersByIds(array $playerIds): array
    {
        return $this->model
            ->whereIn('id', $playerIds)
            ->whereNotNull('sun_time')
            ->orderBy('sun_time', 'asc')
            ->limit(10)
            ->get(['username', 'sun_time'])
            ->toArray();
    }

    public function getSunRankInGroup(array $playerIds, string $sunTime): int
    {
        return $this->model
            ->whereIn('id', $playerIds)
            ->whereNotNull('sun_time')
            ->where('sun_time', '<', $sunTime)
            ->count() + 1;
    }
}

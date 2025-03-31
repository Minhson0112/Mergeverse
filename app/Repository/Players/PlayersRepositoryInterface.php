<?php

namespace App\Repository\Players;

interface PlayersRepositoryInterface
{
    public function getModel(): string;
    public function findByDiscordId(string $discordId);
    public function update(int $id, array $data);
    public function getTop10Players();
    public function getRankByScore(int $score);
    public function getTop10PlayersByIds(array $ids);
    public function getRankInGroup(int $playerId, array $groupedPlayerIds);
    public function getTop10SunPlayers();
    public function getSunRankByTime($sunTime);
    public function getFastestSunPlayersByIds(array $playerIds);
    public function getSunRankInGroup(array $playerIds, string $sunTime);
    public function getTop10PlayersRaw();
    public function getTop10PlayersByIdsRaw(array $ids);
    public function resetScores();
}

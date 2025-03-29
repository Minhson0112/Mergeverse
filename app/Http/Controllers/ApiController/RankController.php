<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Players\PlayersRepositoryInterface;
use App\Repository\GuildPlayer\GuildPlayerRepositoryInterface;

class RankController extends Controller
{
    public function __construct(
        protected PlayersRepositoryInterface $playersRepo,
        protected GuildPlayerRepositoryInterface $guildPlayerRepo,
    ) {}

    public function globalRank(Request $request)
    {
        $discordId = $request->input('discord_id');

        // Lấy top 10 người chơi có điểm cao nhất
        $top10 = $this->playersRepo->getTop10Players();

        // Lấy người dùng hiện tại
        $player = $this->playersRepo->findByDiscordId($discordId);

        $userRank = null;
        $userScore = null;

        if ($player) {
            $userScore = $player->highest_score;
            $userRank = $this->playersRepo->getRankByScore($player->highest_score);
        }

        return response()->json([
            'top10' => $top10,
            'user_rank' => $userRank,
            'user_score' => $userScore,
        ]);
    }

    public function localRank(Request $request)
    {
        $discordId = $request->input('discord_id');
        $guildId = $request->input('guild_id');

        if (!$discordId || !$guildId) {
            return response()->json(['error' => 'Thiếu discord_id hoặc guild_id'], 400);
        }

        // Mặc định null
        $userRank = null;
        $userScore = null;

        // Lấy player hiện tại (nếu có)
        $player = $this->playersRepo->findByDiscordId($discordId);
        $playerId = $player?->id;

        // Lấy toàn bộ player_id thuộc về guild này
        $playerIds = $this->guildPlayerRepo->getPlayerIdsByGuildId($guildId);

        // Lấy top 10 trong danh sách đó
        $top10 = $this->playersRepo->getTop10PlayersByIds($playerIds);

        // Nếu player tồn tại và thuộc guild này
        if ($player && in_array($player->id, $playerIds)) {
            $userScore = $player->highest_score;
            $userRank = $this->playersRepo->getRankInGroup($player->id, $playerIds);
        }

        return response()->json([
            'top10' => $top10,
            'user_rank' => $userRank,
            'user_score' => $userScore,
        ]);
    }

    public function sync(Request $request)
    {
        $discordId = $request->input('discord_id');
        $guildId = $request->input('guild_id');

        if (!$discordId || !$guildId) {
            return response()->json(['error' => 'Thiếu discord_id hoặc guild_id'], 400);
        }

        $player = $this->playersRepo->findByDiscordId($discordId);

        // Nếu player chưa tồn tại (chưa chơi game bao giờ)
        if (!$player) {
            return response()->json([
                'status' => 'skipped',
                'message' => 'Người dùng chưa từng chơi game.'
            ]);
        }

        // Nếu đã có trong bảng guild_player thì bỏ qua
        $exists = $this->guildPlayerRepo->exists($player->id, $guildId);
        if ($exists) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Đã đồng bộ trước đó.'
            ]);
        }

        // Tạo bản ghi mới
        $this->guildPlayerRepo->create([
            'player_id' => $player->id,
            'guild_id' => $guildId,
            'last_played_at' => now(),
        ]);

        return response()->json([
            'status' => 'created',
            'message' => 'Đồng bộ thành công.'
        ]);
    }

    public function globalSunRank(Request $request)
    {
        $discordId = $request->input('discord_id');

        // Lấy top 10 người có sun_time nhỏ nhất (nhanh nhất)
        $top10 = $this->playersRepo->getTop10SunPlayers();

        $userRank = null;
        $userTime = null;

        if ($discordId) {
            $player = $this->playersRepo->findByDiscordId($discordId);
            if ($player && $player->sun_time !== null) {
                $userTime = $player->sun_time;
                $userRank = $this->playersRepo->getSunRankByTime($userTime);
            }
        }

        return response()->json([
            'top10' => $top10,
            'user_rank' => $userRank,
            'user_time' => $userTime,
        ]);
    }

    public function localSunRank(Request $request)
    {
        $discordId = $request->input('discord_id');
        $guildId = $request->input('guild_id');

        if (!$guildId) {
            return response()->json(['error' => 'Thiếu guild_id'], 400);
        }

        $player = $this->playersRepo->findByDiscordId($discordId);
        $playerId = $player?->id;

        // Lấy danh sách player_id trong guild
        $playerIds = $this->guildPlayerRepo->getPlayerIdsByGuildId($guildId);

        // Lấy top 10 người có sun_time nhỏ nhất (trong danh sách player_ids)
        $top10 = $this->playersRepo->getFastestSunPlayersByIds($playerIds);

        $userRank = null;
        $userTime = null;

        if ($playerId && in_array($playerId, $playerIds) && $player->sun_time !== null) {
            $userTime = $player->sun_time;
            $userRank = $this->playersRepo->getSunRankInGroup($playerIds, $userTime);
        }

        return response()->json([
            'top10' => $top10,
            'user_rank' => $userRank,
            'user_time' => $userTime,
        ]);
    }
}

<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repository\Players\PlayersRepositoryInterface;
use App\Repository\GuildPlayer\GuildPlayerRepositoryInterface;
use App\Repository\SeasonGlobalTop10\SeasonGlobalTop10RepositoryInterface;
use App\Repository\SeasonGuildTop10\SeasonGuildTop10RepositoryInterface;
use App\Repository\SeasonHistory\SeasonHistoryRepositoryInterface;

class SeasonController extends Controller
{
    public function __construct(
        protected PlayersRepositoryInterface $playersRepo,
        protected GuildPlayerRepositoryInterface $guildPlayerRepo,
        protected SeasonGlobalTop10RepositoryInterface $globalTopRepo,
        protected SeasonGuildTop10RepositoryInterface $guildTopRepo,
        protected SeasonHistoryRepositoryInterface $seasonRepo,
    ) {}

    public function resetSeason(Request $request)
    {
        DB::beginTransaction();
    
        try {
            // 1. Lấy mùa hiện tại (chưa kết thúc)
            $latestSeason = $this->seasonRepo->getLatestSeason();
            $seasonId = $latestSeason?->id;
    
            // 2. Nếu có mùa hiện tại thì lưu lại top 10
            if ($seasonId) {
                // 2.1 Top 10 Global
                $top10Global = $this->playersRepo->getTop10PlayersRaw();
                foreach ($top10Global as $index => $player) {
                    $this->globalTopRepo->create([
                        'season_id' => $seasonId,
                        'player_id' => $player->id,
                        'rank' => $index + 1,
                        'score' => $player->highest_score,
                        'sun_time' => $player->sun_time,
                    ]);
                }
    
                // 2.2 Top 10 theo từng guild
                $guildIds = $this->guildPlayerRepo->getAllGuildIds();
                foreach ($guildIds as $guildId) {
                    $playerIds = $this->guildPlayerRepo->getPlayerIdsByGuildId($guildId);
                    $top10Guild = $this->playersRepo->getTop10PlayersByIdsRaw($playerIds);
    
                    foreach ($top10Guild as $index => $player) {
                        $this->guildTopRepo->create([
                            'season_id' => $seasonId,
                            'guild_id' => $guildId,
                            'player_id' => $player->id,
                            'rank' => $index + 1,
                            'score' => $player->highest_score,
                            'sun_time' => $player->sun_time,
                        ]);
                    }
                }
    
                // 3. Kết thúc mùa hiện tại
                $this->seasonRepo->endSeason($seasonId);
            }
    
            // 4. Tạo mùa mới
            $newSeason = $this->seasonRepo->createNewSeason();
            $newSeasonId = $newSeason->id;
    
            // 5. Reset điểm và sun_time
            $this->playersRepo->resetScores();
    
            DB::commit();
    
            return response()->json([
                'message' => 'Chuyển mùa thành công',
                'season_id' => $newSeasonId,
                'season_name' => 'Mùa ' . $newSeasonId,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Lỗi khi chuyển mùa',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function localRankSeason(Request $request)
    {
        $guildId = $request->input('guild_id');
        $seasonNumber = $request->input('season');
    
        if (!$guildId || !$seasonNumber) {
            return response()->json(['error' => 'Thiếu guild_id hoặc season'], 400);
        }
    
        // Tìm season theo id (mùa số bao nhiêu)
        $season = $this->seasonRepo->findById($seasonNumber);
    
        if (!$season) {
            return response()->json(['error' => 'Mùa không tồn tại.'], 404);
        }
    
        if ($season->end_at === null) {
            return response()->json([
                'message' => 'Đây là mùa hiện tại.',
                'is_current_season' => true
            ]);
        }

        // Kiểm tra guild_id có tồn tại trong bảng top10 không
        $exists = $this->guildTopRepo->existsBySeasonAndGuild($season->id, $guildId);
        if (!$exists) {
            return response()->json([
                'error' => 'Server này không có dữ liệu xếp hạng trong mùa này.',
                'not_found' => true
            ], 404);
        }
        
        // Nếu là mùa cũ, lấy top 10 từ bảng season_guild_top10
        $top10 = $this->guildTopRepo->getTop10BySeasonAndGuild($season->id, $guildId);
    
        return response()->json([
            'is_current_season' => false,
            'top10' => $top10
        ]);
    }

    public function globalRankSeason(Request $request)
    {
        $seasonNumber = $request->input('season');

        if (!$seasonNumber) {
            return response()->json(['error' => 'Thiếu season'], 400);
        }

        // Tìm season
        $season = $this->seasonRepo->findById($seasonNumber);

        if (!$season) {
            return response()->json(['error' => 'Mùa không tồn tại.'], 404);
        }

        if ($season->end_at === null) {
            return response()->json([
                'message' => 'Đây là mùa hiện tại.',
                'is_current_season' => true
            ]);
        }

        // Lấy top 10 toàn cầu mùa đó
        $top10 = $this->globalTopRepo->getTop10BySeason($season->id);

        return response()->json([
            'is_current_season' => false,
            'top10' => $top10
        ]);
    }
    
}

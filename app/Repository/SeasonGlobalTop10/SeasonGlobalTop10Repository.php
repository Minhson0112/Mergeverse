<?php

namespace App\Repository\SeasonGlobalTop10;
use App\Repository\Base\BaseRepository;
use App\Models\SeasonGlobalTop10;

class SeasonGlobalTop10Repository extends BaseRepository implements SeasonGlobalTop10RepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return SeasonGlobalTop10::class;
    }
    
    public function getTop10BySeason(int $seasonId): array
    {
        return $this->model
            ->with('player:id,username') // Chỉ lấy username từ quan hệ player
            ->where('season_id', $seasonId)
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
}
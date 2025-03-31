<?php

namespace App\Repository\SeasonHistory;
use App\Models\SeasonHistory;
use App\Repository\Base\BaseRepository;

class SeasonHistoryRepository extends BaseRepository implements SeasonHistoryRepositoryInterface
{
    #[\Override]
    public function getModel(): string
    {
        return SeasonHistory::class;
    }

    /**
     * Tìm một mùa theo ID (số mùa)
     */
    public function findById(int $seasonId): ?SeasonHistory
    {
        return $this->model->find($seasonId);
    }
    
    /**
     * Lấy mùa gần nhất (mùa chưa kết thúc hoặc mùa mới nhất theo id)
     */
    public function getLatestSeason()
    {
        return $this->model
            ->orderByDesc('id')
            ->whereNull('end_at')
            ->first();
    }

    /**
     * Kết thúc mùa hiện tại bằng cách set end_at = now()
     */
    public function endSeason(int $id)
    {
        return $this->model->where('id', $id)->update([
            'end_at' => now(),
        ]);
    }

    /**
     * Tạo mùa mới với start_at = thời gian hiện tại
     */
    public function createNewSeason()
    {
        return $this->model->create([
            'start_at' => now(),
        ]);
    }
}
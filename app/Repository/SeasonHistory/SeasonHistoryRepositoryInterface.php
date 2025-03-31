<?php

namespace App\Repository\SeasonHistory;
use App\Models\SeasonHistory;

interface SeasonHistoryRepositoryInterface
{
    public function getModel(): string;
    public function getLatestSeason();
    public function endSeason(int $id);
    public function createNewSeason();
    public function findById(int $seasonId): ?SeasonHistory;
}
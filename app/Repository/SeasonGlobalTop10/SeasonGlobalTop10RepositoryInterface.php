<?php

namespace App\Repository\SeasonGlobalTop10;

interface SeasonGlobalTop10RepositoryInterface
{
    public function getModel(): string;
    public function getTop10BySeason(int $seasonId): array;
}
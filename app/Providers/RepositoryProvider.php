<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Players\PlayersRepositoryInterface;
use App\Repository\Players\PlayersRepository;
use App\Repository\GuildPlayer\GuildPlayerRepositoryInterface;
use App\Repository\GuildPlayer\GuildPlayerRepository;
use App\Repository\SeasonHistory\SeasonHistoryRepositoryInterface;
use App\Repository\SeasonHistory\SeasonHistoryRepository;
use App\Repository\SeasonGlobalTop10\SeasonGlobalTop10RepositoryInterface;
use App\Repository\SeasonGlobalTop10\SeasonGlobalTop10Repository;
use App\Repository\SeasonGuildTop10\SeasonGuildTop10RepositoryInterface;
use App\Repository\SeasonGuildTop10\SeasonGuildTop10Repository;

class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind từng interface với implementation
        $this->app->bind(PlayersRepositoryInterface::class, PlayersRepository::class);
        $this->app->bind(GuildPlayerRepositoryInterface::class, GuildPlayerRepository::class);
        $this->app->bind(SeasonHistoryRepositoryInterface::class, SeasonHistoryRepository::class);
        $this->app->bind(SeasonGlobalTop10RepositoryInterface::class, SeasonGlobalTop10Repository::class);
        $this->app->bind(SeasonGuildTop10RepositoryInterface::class, SeasonGuildTop10Repository::class);
    }

    public function boot(): void
    {
        //
    }
}

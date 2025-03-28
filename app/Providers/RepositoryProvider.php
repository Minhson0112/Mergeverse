<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repository Interface
use App\Repository\Players\PlayersRepositoryInterface;
use App\Repository\GuildPlayer\GuildPlayerRepositoryInterface;

// Repository Implementation
use App\Repository\Players\PlayersRepository;
use App\Repository\GuildPlayer\GuildPlayerRepository;

class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind từng interface với implementation
        $this->app->bind(PlayersRepositoryInterface::class, PlayersRepository::class);
        $this->app->bind(GuildPlayerRepositoryInterface::class, GuildPlayerRepository::class);
    }

    public function boot(): void
    {
        //
    }
}

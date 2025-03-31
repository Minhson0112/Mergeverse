<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi các seeder cụ thể ở đây
        $this->call([
            SeasonHistoriesSeeder::class,
        ]);
    }
}

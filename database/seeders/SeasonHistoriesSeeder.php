<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeasonHistoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('season_histories')->insert([
            'id' => 1,
            'start_at' => Carbon::now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

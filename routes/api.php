<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\GameOverController;
use App\Http\Controllers\ApiController\RankController;

Route::post('/game-over', [GameOverController::class, 'store']);
Route::get('/global-rank', [RankController::class, 'globalRank']);
Route::get('/local-rank', [RankController::class, 'localRank']);
Route::post('/sync', [RankController::class, 'sync']);
Route::get('/global-sun-rank', [RankController::class, 'globalSunRank']);
Route::get('/local-sun', [RankController::class, 'localSunRank']);
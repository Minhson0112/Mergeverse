<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ApiController\GameOverController;

Route::get('/start-game', [GameController::class, 'startGame']);
Route::post('/game-over', [GameOverController::class, 'store']);

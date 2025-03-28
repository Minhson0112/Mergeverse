<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\GameOverController;

Route::post('/game-over', [GameOverController::class, 'store']);

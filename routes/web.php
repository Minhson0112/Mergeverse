<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController; 

Route::get('/start-game', [GameController::class, 'startGame']);
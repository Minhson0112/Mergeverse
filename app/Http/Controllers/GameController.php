<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function startGame(Request $request)
    {
        $path = public_path('game/index.html');
        return response()->file($path);
    }
}

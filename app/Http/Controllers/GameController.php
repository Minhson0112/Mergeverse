<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function startGame(Request $request)
    {
        $discordId = $request->query('discord_id');
        $userName = $request->query('username');

        if (!$discordId || !$userName) {
            return response()->json([
                'error' => 'missing dicord id or user name'
            ], 400);
        }

        return view('game.index', ['discord_id' => $discordId, 'username' => $userName]);
    }
}

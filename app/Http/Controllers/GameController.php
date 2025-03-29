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
        $guildId = $request->query('guild_id');

        if (!$discordId || !$userName || !$guildId) {
            return response()->json([
                'error' => 'hãy dùng link bot gửi'
            ], 400);
        }

        return view('game.index', ['discord_id' => $discordId, 'username' => $userName, 'guild_id' => $guildId]);
    }
}

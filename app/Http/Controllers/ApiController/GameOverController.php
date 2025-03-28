<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Players\PlayersRepositoryInterface;
class GameOverController extends Controller
{
    public function __construct(
        protected PlayersRepositoryInterface $playersRepo,
    )
    {}
    public function store(Request $request)
    {
        $discordId = $request->input('discord_id');
        $username = $request->input('username');
        $score = $request->input('score');
        $sunTime = $request->input('sun_time');

        $player = $this->playersRepo->findByDiscordId($discordId);

        if (!$player) {
            // Nếu chưa tồn tại thì tạo mới
            $this->playersRepo->create([
                'discord_id' => $discordId,
                'username' => $username,
                'highest_score' => $score,
                'sun_time' => $sunTime,
            ]);
        } else {
            // Nếu tồn tại thì kiểm tra và cập nhật nếu cần
            $updatedData = [];

            if ($player->username !== $username) {
                $updatedData['username'] = $username;
            }

            if ($score > $player->highest_score) {
                $updatedData['highest_score'] = $score;
            }

            if ($sunTime !== null && ($player->sun_time === null || $sunTime < $player->sun_time)) {
                $updatedData['sun_time'] = $sunTime;
            }

            if (!empty($updatedData)) {
                $this->playersRepo->update($player->id, $updatedData);
            }
        }

        return response()->json(['status' => 'success']);
        }
}

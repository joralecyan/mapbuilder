<?php


namespace App\Services;

use App\Models\Board;
use App\Models\BoardPoint;

class BoardService
{
    /**
     * @param $gameId
     * @param $userId
     */
    public function initBoard($gameId, $userId): void
    {
        $board = Board::firstOrCreate([
            'game_id' => $gameId,
            'user_id' => $userId,
        ], [
            'map' => self::getEmptyMap()
        ]);

        BoardPoint::firstOrCreate([
            'board_id' => $board->id
        ], []);
    }

    /**
     * @return array
     */
    public static function getEmptyMap(): array
    {
        return [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 7, 0, 6, 0, 0, 0, 0, 0],
            [0, 6, 0, 0, 0, 0, 0, 0, 7, 6, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 6, 7, 0, 0, 0, 0, 0, 0, 6, 0],
            [0, 0, 0, 0, 0, 6, 0, 7, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        ];
    }

    /**
     * @param $game
     * @return void
     */
    public static function markWinner($game): void
    {
        $winnerBoard = $game->boards()->with('points', function ($q) {
            $q->orderBy('total', 'desc');
        })->orderBy('points.total', 'desc')->first();

        $winnerBoard->update(['is_win' => 1]);
    }
}

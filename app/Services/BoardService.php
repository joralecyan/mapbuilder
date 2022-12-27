<?php


namespace App\Services;

use App\Models\Board;
use App\Models\BoardPoint;

class BoardService
{
    /**
     * @param $game_id
     * @param $user_id
     */
    public function initBoard($game_id, $user_id): void
    {
        $board = Board::firstOrCreate([
            'game_id' => $game_id,
            'user_id' => $user_id,
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
}

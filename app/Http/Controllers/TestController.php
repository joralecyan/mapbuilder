<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Game;
use App\Services\PointsService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $game = Game::first();
        $winnerBoard = $game->boards() ->join('board_points', 'boards.id', '=', 'board_points.board_id')
            ->select('boards.*')
            ->orderBy('board_points.total', 'desc')
            ->first();
        $winnerBoard->update(['is_win' => 1]);
       dd($winnerBoard);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardRequest;
use App\Http\Resources\BoardResource;
use App\Models\Board;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;

class BoardController extends Controller
{
    protected GameService $gameService;

    /**
     * BoardController constructor.
     * @param GameService $gameService
     */
    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * @param Board $board
     * @return JsonResponse
     */
    public function getBoard(Board $board): JsonResponse
    {
        return response()->json(['status' => 'success', 'board' => new BoardResource($board)], 200);
    }

    /**
     * @param Board $board
     * @param BoardRequest $request
     * @return JsonResponse
     */
    public function update(Board $board, BoardRequest $request): JsonResponse
    {
        $round = ++$board->round;
        $board->update([
            'map' => $request->map,
            'round' => $round,
        ]);

        $stage = str_replace(',', '', $board->game->season->stages);
        $board->points->update([$stage . '_coins' => $request->get('coins')]);

        if ($board->game->boards()->avg('round') == $round) {
            $this->gameService->newTask($board->game);
        }

        return response()->json(['status' => 'success'], 200);
    }
}

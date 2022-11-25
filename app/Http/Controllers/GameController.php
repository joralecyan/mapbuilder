<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\TaskResource;
use App\Models\Game;
use App\Services\BoardService;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected GameService $gameService;
    protected BoardService $boardService;

    /**
     * GameController constructor.
     */
    public function __construct()
    {
        $this->gameService = new GameService();
        $this->boardService = new BoardService();
    }

    /**
     * @param Game $game
     * @return JsonResponse
     */
    public function getGame(Game $game): JsonResponse
    {
        $game->load('boards.user', 'missions', 'season', 'last_task');
        return response()->json(['status' => 'success', 'game' =>  new GameResource($game)], 200);
    }

    /**
     * @return JsonResponse
     */
    public function getGames(): JsonResponse
    {
        $games = Game::withCount('boards')->pending()->latest()->paginate(m_per_page());
        return response()->json(['status' => 'success', 'games' =>  GameResource::collection($games)], 200);
    }

    /**
     * @param Game $game
     * @return JsonResponse
     */
    public function getLastTask(Game $game): JsonResponse
    {
        return response()->json(['status' => 'success', 'last_task' =>  new TaskResource($game->last_task->task)], 200);
    }

    /**
     * @param GameRequest $request
     * @return JsonResponse
     */
    public function store(GameRequest $request): JsonResponse
    {
        $user = $request->user();
        $game = Game::create([
            'max_count' => $request->max_count,
            'user_id' => $user->id,
        ]);

        $this->boardService->initBoard($game->id, $user->id);

        return response()->json(['status' => 'success', 'game_id' => $game->id], 200);
    }

    /**
     * @param Game $game
     * @param Request $request
     * @return JsonResponse
     */
    public function enroll(Game $game, Request $request): JsonResponse
    {
        $user = $request->user();
        $this->boardService->initBoard($game->id, $user->id);

        if(count($game->boards) == $game->max_count){
            $this->gameService->storeMissions($game);
            $task = $this->gameService->newTask($game);
            $task->load('figures', 'items');
            return response()->json(['status' => 'success', 'task' => new TaskResource($task)], 200);
        }

        return response()->json(['status' => 'success'], 200);
    }
}

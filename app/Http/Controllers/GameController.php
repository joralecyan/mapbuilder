<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Models\Board;
use App\Models\Game;
use App\Models\Mission;
use App\Services\BoardService;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected $game_service;
    protected $board_service;

    /**
     * GameController constructor.
     */
    public function __construct()
    {
        $this->game_service = new GameService();
        $this->board_service = new BoardService();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGame($id): JsonResponse
    {
        $game = Game::find($id);
        $game->load('boards.user', 'missions', 'season');
        return response()->json(['status' => 'success', 'game' =>  new GameResource($game)], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGames(): JsonResponse
    {
        $games = Game::withCount('boards')->pending()->latest()->paginate(m_per_page());
        return response()->json(['status' => 'success', 'games' =>  GameResource::collection($games)], 200);
    }

    /**
     * @param GameRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GameRequest $request): JsonResponse
    {
        $user = $request->user();

        $game = Game::create([
            'max_count' => $request->max_count,
            'user_id' => $user->id,
        ]);

        $this->board_service->initBoard($game->id, $user->id);

        return response()->json(['status' => 'success', 'game_id' => $game->id], 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enroll($id, Request $request): JsonResponse
    {
        $user = $request->user();
        $game = Game::find($id);

        $this->board_service->initBoard($game->id, $user->id);

        if(count($game->boards) == $game->max_count){
            $this->game_service->storeMissions($game);
            $task = $this->game_service->newTask($game);
            $task->load('figures', 'items');
            return response()->json(['status' => 'success', 'task' => new TaskResource($task)], 200);
        }

        return response()->json(['status' => 'success'], 200);
    }
}

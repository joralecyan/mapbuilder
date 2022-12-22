<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\TaskResource;
use App\Models\Game;
use App\Services\BoardService;
use App\Services\GameService;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
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

        $version = new Version2X('18.207.226.192:3000');
        $client = new Client($version);

        $client->initialize();
        $client->emit('message-server', [
            'message' => 'hello'
        ]);
        $client->close();

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
        if ($game->last_task) {
            $task = $game->last_task->task;
            return response()->json(['status' => 'success', 'last_task' =>  new TaskResource()], 200);
        }

        return response()->json(['status' => 'error', 'message' =>  'There are no task created yet'], 400);
    }

    /**
     * @param GameRequest $request
     * @return JsonResponse
     */
    public function store(GameRequest $request): JsonResponse
    {
        $user = $request->user();
        $game = Game::create([
            'max_players' => $request->get('max_players'),
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

        if(count($game->boards) == $game->max_players){
            $this->gameService->storeMissions($game);
            $this->gameService->newTask($game);
        }

        return response()->json(['status' => 'success'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\TaskResource;
use App\Models\Game;
use App\Models\Season;
use App\Services\BoardService;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        $game->load('boards.user', 'boards.points', 'missions', 'season', 'last_task')->loadCount('boards');

        return response()->json(['status' => 'success', 'game' => new GameResource($game)], 200);
    }

    /**
     * @return JsonResponse
     */
    public function getGames(): JsonResponse
    {
        $games = Game::withCount('boards')->pending()->latest()->paginate(m_per_page());

        return response()->json(['status' => 'success', 'games' => GameResource::collection($games)], 200);
    }

    /**
     * @param Game $game
     * @return JsonResponse
     */
    public function getLastTask(Game $game): JsonResponse
    {
        if ($game->last_task) {
            return response()->json(['status' => 'success', 'last_task' => new TaskResource($game->last_task->task)], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'There are no task created yet'], 400);
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
            'season_id' => Season::FIRST_SEASON,
        ]);
        $this->boardService->initBoard($game->id, $user->id);

        $game->loadCount('boards');
        if ($game->boards_count == $game->max_players) {
            $this->gameService->startGame($game);
        }

        return response()->json(['status' => 'success', 'game_id' => $game->id], 200);
    }

    /**
     * @param Game $game
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function enroll(Game $game, Request $request): JsonResponse
    {
        $user = $request->user();
        $boardsCount = count($game->boards);

        if ($boardsCount < $game->max_players) {
            $this->boardService->initBoard($game->id, $user->id);
            $boardsCount++;
            if ($boardsCount == $game->max_players) {
                $this->gameService->startGame($game);
            }

            return response()->json(['status' => 'success'], 200);
        }

        throw ValidationException::withMessages(['game' => __('Already enrolled')]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\UserResource;
use App\Models\Board;
use App\Models\Game;
use App\Models\Mission;
use App\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected $game_service;

    /**
     * GameController constructor.
     */
    public function __construct()
    {
        $this->game_service = new GameService();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGames()
    {
        $games = Game::withCount('boards')->pending()->paginate(m_per_page());
        return response()->json(['status' => 'success', 'games' =>  GameResource::collection($games)], 200);
    }

    /**
     * @param GameRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GameRequest $request)
    {
        $user = $request->user();

        $game = Game::create([
            'max_count' => $request->max_count,
            'user_id' => $user->id,
        ]);

        Board::create([
            'game_id' => $game->id,
            'user_id' => $user->id,
        ]);

        return response()->json(['status' => 'success', 'game_id' => $game->id], 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enroll($id, Request $request)
    {
        $user = $request->user();
        $game = Game::find($id);
        Board::create([
            'game_id' => $game->id,
            'user_id' => $user->id,
        ]);
        if(count($game->boards) == $game->max_count){
            $this->game_service->storeMissions($game);
        }

        return response()->json(['status' => 'success'], 200);
    }
}

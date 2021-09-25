<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardRequest;
use App\Http\Resources\BoardResource;
use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBoard($id): JsonResponse
    {
        $board = Board::find($id);

        return response()->json(['status' => 'success', 'board' => new BoardResource($board)], 200);
    }

    /**
     * @param $id
     * @param BoardRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, BoardRequest $request): JsonResponse
    {
        $board = Board::find($id);
        $board->update([
            'map' => $request->map
        ]);

        return response()->json(['status' => 'success'], 200);
    }
}

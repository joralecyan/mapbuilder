<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request): JsonResponse
    {
        return response()->json(['status' => 'success', 'user' =>  new UserResource($request->user())], 200);
    }
}

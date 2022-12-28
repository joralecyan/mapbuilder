<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Services\PointsService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
       dd( (new PointsService())->calculateLakeside(Board::find(1)));
    }
}

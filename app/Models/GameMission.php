<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMission extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'game_missions';

    /**
     * @var string[]
     */
    protected $fillable = ['game_id', 'mission_id', 'step'];
}

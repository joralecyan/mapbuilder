<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardPoint extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'board_points';

    /**
     * @var string[]
     */
    protected $fillable = ['board_id', 'AB_points_A', 'AB_points_B', 'BC_points_B', 'BC_points_C', 'CD_points_C',
        'CD_points_D', 'DA_points_D', 'DA_points_A', 'AB_coins', 'BC_coins', 'CD_coins', 'DA_coins', 'AB_goblins',
        'BC_goblins', 'CD_goblins', 'DA_goblins', 'coins', 'AB_points', 'BC_points', 'CD_points', 'DA_points', 'total'];

    /**
     * @return BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}

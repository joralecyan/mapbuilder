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
    protected $fillable = ['board_id', 'coins', 'AB_points', 'BC_points', 'CD_points', 'DA_points'];

    /**
     * @return BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}

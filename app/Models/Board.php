<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Board extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'boards';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'game_id', 'round', 'map', 'is_win'];

    /**
     * @var string[]
     */
    protected $casts = ['map' => 'array'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function points(): HasOne
    {
        return $this->hasOne(BoardPoint::class);
    }
}

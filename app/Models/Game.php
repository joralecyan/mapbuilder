<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';

    /**
     * @var string
     */
    protected $table = 'games';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'status', 'max_count'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function boards(): HasMany
    {
        return $this->hasMany(Board::class, 'game_id', 'id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePending($query)
    {
        return $query->whereStatus(self::STATUS_PENDING);
    }
}

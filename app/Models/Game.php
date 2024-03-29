<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

    /**
     * @var string
     */
    protected $table = 'games';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'status', 'max_players', 'season_id'];

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
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function missions(): HasMany
    {
        return $this->hasMany(GameMission::class, 'game_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(GameTask::class, 'game_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function last_task(): HasOne
    {
        return $this->hasOne(GameTask::class, 'game_id', 'id')->latest();
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

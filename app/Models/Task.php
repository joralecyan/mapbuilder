<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'type', 'duration', 'direction'];

    /**
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'task_items', 'item_id', 'task_id');
    }

    /**
     * @return BelongsToMany
     */
    public function figures(): BelongsToMany
    {
        return $this->belongsToMany(Figure::class, 'task_figures', 'figure_id', 'task_id');
    }
}

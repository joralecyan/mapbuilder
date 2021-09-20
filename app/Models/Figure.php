<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Figure extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'figures';

    /**
     * @var array
     */
    protected $fillable = ['figure', 'is_extra'];

    /**
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'task_items');
    }

    /**
     * @return BelongsToMany
     */
    public function figures(): BelongsToMany
    {
        return $this->belongsToMany(Figure::class, 'task_figures');
    }
}

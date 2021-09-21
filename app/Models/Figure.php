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
     * @var string[]
     */
    protected $casts = ['figure' => 'array'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'missions';

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'description', 'type'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'items';

    /**
     * @var string[]
     */
    protected $fillable = ['name'];
}

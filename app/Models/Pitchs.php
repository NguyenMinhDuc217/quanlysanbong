<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitchs extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'describe',
        'type_pitch',
        'avartar',
        'screenshort',
        'average_rating',
        'total_rating',
        'total_set',
        'status',
    ];

}

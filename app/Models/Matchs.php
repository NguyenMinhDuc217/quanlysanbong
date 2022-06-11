<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matchs extends Model
{
    use HasFactory;
    protected $fillable = [
        'pitch_id',
        'date_event',
        'start_time',
        'end_time',
        'status',
    ];
}

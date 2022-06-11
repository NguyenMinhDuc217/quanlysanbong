<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_set_pitchs extends Model
{
    use HasFactory;
    protected $fillable = [
        'picth_id',
        'user_id',
        'service_id',
        'date_event',
        'start_time',
        'end_time',
        'total',
    ];
}

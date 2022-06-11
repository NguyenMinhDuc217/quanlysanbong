<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set_pitchs extends Model
{
    use HasFactory;
    protected $fillable = [
        'picth_id',
        'user_id',
        'service_id',
        'detail_set_pitch_id',
    ];
}

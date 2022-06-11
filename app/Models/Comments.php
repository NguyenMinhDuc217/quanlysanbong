<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'picth_id',
        'user_id',
        'content',
        'rating',
        'like',
        'dislike',
    ];
}

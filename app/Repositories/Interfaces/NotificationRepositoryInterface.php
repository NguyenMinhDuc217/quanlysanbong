<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Repositories\TeamRepository;

interface NotificationRepositoryInterface
{
    public function listNotification();
}
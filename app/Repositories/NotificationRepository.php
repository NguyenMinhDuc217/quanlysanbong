<?php

namespace App\Repositories;

use App\Models\Notifications;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Teams;
use Illuminate\Support\Facades\Auth;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function listNotification()
    {
        $notifications = Notifications::orderby('created_at', 'DESC')->paginate(5)->appends(request()->query());
        return view('notification.index', compact('notifications'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationController extends Controller
{
    private $notificationRepository;
    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }
    public function listNotification(){
        return $this->notificationRepository->listNotification();
    }
    public function searchNotification(Request $request){
        return $this->notificationRepository->searchNotification($request);
    }
}

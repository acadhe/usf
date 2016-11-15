<?php

namespace App\Composers;


use App\Contracts\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserNotificationComposer
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function compose(View $view){
        if (!Auth::guest()){
            $user = Auth::user();
            $notifications = $this->notificationService->findNotificationChangesByUserIdOrderMostRecent($user->id,10);
            $view->with('navbar_notifications',$notifications);
        }
    }
}
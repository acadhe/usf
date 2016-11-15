<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\NotificationRepository;
use App\Models\Notification;

class NotificationRepositoryImpl implements NotificationRepository
{

    public function save(Notification $notification)
    {
        return $notification->save();
    }

    public function findByUserId($user_id)
    {
        return Notification::where('user_id','=',$user_id)->first();
    }
}
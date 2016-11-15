<?php

namespace App\Contracts\Repositories;


use App\Models\Notification;

interface NotificationRepository
{

    public function findByUserId($user_id);
    
    /**
     * @param Notification $notification
     * @return boolean
     */
    public function save(Notification $notification);
}
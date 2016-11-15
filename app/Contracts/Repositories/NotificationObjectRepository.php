<?php

namespace App\Contracts\Repositories;


use App\Models\Notification;
use App\Models\NotificationObject;
use Illuminate\Database\Eloquent\Builder;

interface NotificationObjectRepository
{
    public function deleteById($id);

    public function findByQuery(Builder $q);

    /**
     * @param Notification $notification
     * @param $object_id
     * @param $object_type
     * @return NotificationObject
     */
    public function findByNotificationAndObjectIdAndObjectType(Notification $notification,$object_id,$object_type);
    
    public function save(NotificationObject $object);

}
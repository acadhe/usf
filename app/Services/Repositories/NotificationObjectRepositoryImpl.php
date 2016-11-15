<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\NotificationObjectRepository;
use App\Models\Notification;
use App\Models\NotificationObject;
use Illuminate\Database\Eloquent\Builder;

class NotificationObjectRepositoryImpl implements NotificationObjectRepository
{
    public function save(NotificationObject $object)
    {
        return $object->save();
    }

    public function deleteById($id)
    {
        return NotificationObject::where('id','=',$id)->delete();
    }

    public function findByQuery(Builder $q)
    {
        return $q->first();
    }

    public function findByNotificationAndObjectIdAndObjectType(Notification $notification, $object_id, $object_type)
    {
        return NotificationObject::where('notification_id','=',$notification->id)->where('object_id','=',$object_id)->where('object_type','=',$object_type)->first();
    }
}
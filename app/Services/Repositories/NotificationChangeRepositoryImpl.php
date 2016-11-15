<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\NotificationChangeRepository;
use App\Models\NotificationChange;
use App\Models\User;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;

class NotificationChangeRepositoryImpl implements NotificationChangeRepository
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function save(NotificationChange $notificationChange)
    {
        return $notificationChange->save();
    }


    public function getUserChangesWithNotificationObjectMostRecent($user_id)
    {
        $query = NotificationChange::query()
            ->with('notificationObject')
            ->join('notification_objects','notification_changes.notification_object_id','=','notification_objects.id')
            ->join('notifications as n','n.id','=','notification_objects.notification_id')
            ->where('n.user_id','=',$user_id)
            ->select('notification_changes.*');
        var_dump($query->getBindings());
        dd($query->toSql());
        return $query->get();
    }

    public function deleteById($id)
    {
        return NotificationChange::where('id','=',$id)->delete();
    }

    public function findAllByQuery(Builder $q)
    {
        return $q->get();
    }

    public function updateUnseenToSeen(User $user)
    {
        NotificationChange::query()
            ->join('notification_objects','notification_changes.notification_object_id','=','notification_objects.id')
            ->join('notifications as n','n.id','=','notification_objects.notification_id')
            ->where('user_id','=',$user->id)
            ->where('seen','=',false)
            ->update(['seen'=>true]);
    }
}
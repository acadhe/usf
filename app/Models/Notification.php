<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int user_id
 * @property int id
 */
class Notification extends Model
{
    public $timestamps = false;

    public function notificationObjects()
    {
        return $this->hasMany(NotificationObject::class,'notification_id','id');
    }
}
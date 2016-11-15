<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationObject
 * @property int notification_id
 * @property int object_id
 * @property string object_type related to object id
 * @property int id
 * @package App\Models
 */
class NotificationObject extends Model
{
    const TYPE_ARTICLE = 'article';
    const TYPE_COMMENT = 'comment';

    public $timestamps = false;

    public function notificationChanges()
    {
        return $this->hasMany(NotificationChange::class,'notification_object_id','id');
    }

    public function isComment(){
        return $this->object_type == self::TYPE_COMMENT;
    }

    public function isArticle(){
        return $this->object_type == self::TYPE_ARTICLE;
    }
}

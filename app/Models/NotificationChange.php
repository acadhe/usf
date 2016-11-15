<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int actor_id
 * @property string action
 * @property int notification_object_id
 * @property string adverb
 * @property string created_at
 * @property NotificationObject notificationObject
 * @property User actor
 * @property string entity_type type of entity that triggers notification. example when user comment an article, the entity type is comment
 * @property string entity_id
 * @property int id
 */
class NotificationChange extends Model
{
    const ENTITY_TYPE_COMMENT = "comment";
    const ACTION_COMMENT = "commented";
    const ACTION_REPLY = "replied";
    const ACTION_CLOSE = "closed";
    const ACTION_VOTE = "voted";
    const ACTION_DELETE = "deleted";

    const ADVERB_YOUR_COMMENT = "your comment";
    const ADVERB_YOU_CREATED = "you created";
    const ADVERB_YOU_FOLLOWED = "you followed";

    public function notificationObject()
    {
        return $this->belongsTo(NotificationObject::class,'notification_object_id','id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class,'actor_id','id');
    }

    public function isActionComment()
    {
        return $this->action == self::ACTION_COMMENT;
    }

    public function isActionReplied()
    {
        return $this->action == self::ACTION_REPLY;
    }

    public function isActionVoted()
    {
        return $this->action == self::ACTION_VOTE;
    }

    public function isActionDeleted()
    {
        return $this->action == self::ACTION_DELETE;
    }

    public function isActionClosed()
    {
        return $this->action == self::ACTION_CLOSE;
    }

    public function isAdverbYourComment()
    {
        return $this->action = self::ADVERB_YOUR_COMMENT;
    }

    public function isAdverbYouCreated()
    {
        return $this->action == self::ADVERB_YOU_CREATED;
    }

    public function isAdverbYouFollowed()
    {
        return $this->action == self::ADVERB_YOU_FOLLOWED;
    }
}

<?php

namespace App\Contracts\Services\Mappers\Notifications;


use App\Models\Article;
use App\Models\Comment;
use App\Models\NotificationChange;
use App\Models\NotificationObject;
use App\Models\User;

class UserReplyCommentNotification extends AbstractNotification
{
    private $comment;
    private $targetArticle;

    /**
     * UserReplyComment constructor.
     * @param NotificationChange $notificationChange
     * @param NotificationObject $notificationObject
     * @param User $actor
     * @param Article $targetArticle
     * @param Comment|null $comment
     */
    public function __construct(NotificationChange $notificationChange,
                                NotificationObject $notificationObject,
                                User $actor, Article $targetArticle, $comment)
    {
        parent::__construct($notificationChange,$notificationObject, $actor);
        $this->comment = $comment;
        $this->targetArticle = $targetArticle;
    }


    public function getAdditionalInfo()
    {
        return $this->comment->content;
    }

    public function getContext()
    {
        return $this->targetArticle->title;
    }

    /**
     * The target of url which is the user will open
     * @return string
     */
    public function getContextUrl()
    {
        return route('article.read',['id'=>$this->targetArticle->id]);
    }
    public function getUserUrl()
    {
        return route('home.panelist',['user_id'=>$this->targetArticle->id]);
    }
}
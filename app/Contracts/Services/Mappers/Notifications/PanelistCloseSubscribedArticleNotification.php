<?php

namespace App\Contracts\Services\Mappers\Notifications;


use App\Models\Article;
use App\Models\NotificationChange;
use App\Models\NotificationObject;
use App\Models\User;

class PanelistCloseSubscribedArticleNotification extends AbstractNotification
{
    private $targetArticle;

    /**
     * PanelistCloseArticle constructor.
     * @param NotificationChange $notificationChange
     * @param NotificationObject $notificationObject
     * @param User $actor panelist that close the article
     * @param Article $targetTargetArticle closed article
     */
    public function __construct(NotificationChange $notificationChange,NotificationObject $notificationObject,User $actor,Article $targetTargetArticle)
    {
        parent::__construct($notificationChange,$notificationObject, $actor);
        $this->targetArticle = $targetTargetArticle;
    }

    public function getAdditionalInfo()
    {
        //no op
        return "";
    }

    /**
     * The context where the notification is created
     * For example, if user comment 'hello' on a 'hello dummy' article,
     * then the context will be the 'hello dummy'
     * @return String
     */
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
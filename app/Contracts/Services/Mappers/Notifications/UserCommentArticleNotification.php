<?php

namespace App\Contracts\Services\Mappers\Notifications;


use App\Models\Article;
use App\Models\Comment;
use App\Models\NotificationChange;
use App\Models\NotificationObject;
use App\Models\User;

class UserCommentArticleNotification extends AbstractNotification
{
    private $article;
    private $comment;
    private $targetArticle;

    /**
     * UserCommentArticle constructor.
     * @param NotificationChange $notificationChange
     * @param NotificationObject $notificationObject
     * @param User $actor
     * @param Article $targetTargetArticle
     * @param Comment|null $comment
     */
    public function __construct(NotificationChange $notificationChange, 
                                NotificationObject $notificationObject, 
                                User $actor, Article $targetTargetArticle, $comment)
    {
        parent::__construct($notificationChange,$notificationObject, $actor);
        $this->article = $targetTargetArticle;
        $this->comment = $comment;
        // $this->targetArticle = $targetArticle;
    }

    public function getAdditionalInfo()
    {
        return $this->comment->content;
    }

    public function getContext()
    {
        return $this->article->title;
    }

    /**
     * The target of url which is the user will open
     * @return string
     */
    public function getContextUrl()
    {
        return route('article.read',['id'=>$this->article->id]);
    }
    public function getUserUrl()
    {
        return route('home.panelist',['user_id'=>$this->article->id]);
    }
}
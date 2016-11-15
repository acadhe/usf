<?php

namespace App\Contracts\Services;


use App\Contracts\Services\Mappers\Notifications\AbstractNotification;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

interface NotificationService
{
    public function setAllNotificationChangesToSeen(User $user);

    /**
     * @param User $actor the commenter
     * @param Article $article commented article
     * @param Comment $comment the new comment
     * @return mixed
     */
    public function addUserCommentArticle(User $actor,Article $article,Comment $comment);

    /**
     * @param User $actor
     * @param Comment $repliedComment replied comment, NOT the new comment
     * @param Article $article
     * @param Comment $comment the new comment
     * @return mixed
     */
    public function addUserReplyCommentInArticle(User $actor,Comment $repliedComment,Article $article,Comment $comment);

    /**
     * Notification when user close article for discussion
     * @param User $actor
     * @param Article $article
     * @return mixed
     */
    public function addPanelistCloseArticle(User $actor,Article $article);

    /**
     * @param $user_id
     * @param $limit
     * @return AbstractNotification[]
     */
    public function findNotificationChangesByUserIdOrderMostRecent($user_id,$limit);

}
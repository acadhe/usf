<?php

namespace App\Services\Services;


use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\CommentRepository;
use App\Contracts\Repositories\NotificationChangeRepository;
use App\Contracts\Repositories\NotificationObjectRepository;
use App\Contracts\Repositories\NotificationRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\Mappers\Notifications\AbstractNotification;
use App\Contracts\Services\Mappers\Notifications\PanelistCloseSubscribedArticleNotification;
use App\Contracts\Services\Mappers\Notifications\UserCommentArticleNotification;
use App\Contracts\Services\Mappers\Notifications\UserReplyCommentNotification;
use App\Contracts\Services\Mappers\Notifications\UserVoteCommentNotification;
use App\Contracts\Services\NotificationService;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\NotificationChange;
use App\Models\NotificationObject;
use App\Models\User;

class NotificationServiceImpl implements NotificationService
{
    private $notifRepo;
    private $notifObjRepo;
    private $notifChangeRepo;
    private $commentRepository;
    private $articleRepository;
    private $userRepository;

    public function __construct(NotificationRepository $notifRepo,
                                NotificationObjectRepository $notifObjRepo,
                                NotificationChangeRepository $notifChangeRepo,
                                ArticleRepository $articleRepository,
                                CommentRepository $commentRepository,
                                UserRepository $userRepository
    ){
        $this->commentRepository = $commentRepository;
        $this->notifRepo = $notifRepo;
        $this->notifObjRepo = $notifObjRepo;
        $this->notifChangeRepo = $notifChangeRepo;
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
    }

    public function addUserCommentArticle(User $actor, Article $article,Comment $comment)
    {
        //if the actor is the article creator, don't add notification
        if ($actor->id != $article->user_id){
            $this->notifyArticleCreatorThatUserHasComment($actor, $article,$comment);
        }
    }

    public function addUserReplyCommentInArticle(User $actor,Comment $repliedComment,Article $article,Comment $comment)
    {
        //if the actor is the article creator, don't add notification
        if ($actor->id != $article->user_id){
            $this->notifyArticleCreatorThatUserHasComment($actor, $article,$comment);
        }
        if ($actor->id != $repliedComment->user_id){
            $this->notifyCommentatorThatUserHasReplyHisorHerComment($actor, $repliedComment,$comment);
        }
    }

    public function constructNotification($notified_user_id,$object_id,$object_type,$action,$actor_id,$adverb,$entity_id,$entity_type){
        $notification = $this->findOrCreateNotificationByUserId($notified_user_id);
        $notifObj = $this->findOrCreateNotificationObject($notification,$object_id,$object_type);
        $this->createNotificationChange($notifObj,$action,$actor_id,$adverb,$entity_type,$entity_id);
    }

    private function notifyCommentatorThatUserHasReplyHisorHerComment(User $actor,Comment $repliedComment,Comment $comment)
    {
        $notified_user_id = $repliedComment->user_id;
        $object_id = $repliedComment->id;
        $object_type = NotificationObject::TYPE_COMMENT;
        $action = NotificationChange::ACTION_REPLY;
        $actor_id = $actor->id;
        $adverb = NotificationChange::ADVERB_YOUR_COMMENT;
        $this->constructNotification($notified_user_id, $object_id, $object_type, $action, $actor_id, $adverb,
            $comment->id,NotificationChange::ENTITY_TYPE_COMMENT);
    }

    public function notifyCommentatorThatUserHasVoteHisorHerComment(User $actor,Comment $comment)
    {
        $notified_user_id = $comment->user_id;
        $object_id = $comment->id;
        $object_type = NotificationObject::TYPE_COMMENT;
        $action = NotificationChange::ACTION_VOTE;
        $actor_id = $actor->id;
        $adverb = NotificationChange::ADVERB_YOUR_COMMENT;
        $this->constructNotification($notified_user_id, $object_id, $object_type, $action, $actor_id, $adverb,
            $comment->id,NotificationChange::ENTITY_TYPE_COMMENT);
    }

    private function notifyArticleCreatorThatUserHasComment(User $actor,Article $article,Comment $comment){
        $notified_user_id = $article->user_id;
        $object_id = $article->id;
        $object_type = NotificationObject::TYPE_ARTICLE;
        $action = NotificationChange::ACTION_COMMENT;
        $actor_id = $actor->id;
        $adverb = NotificationChange::ADVERB_YOU_CREATED;
        $this->constructNotification($notified_user_id, $object_id, $object_type, $action,$actor_id,$adverb,
            $comment->id,NotificationChange::ENTITY_TYPE_COMMENT);
    }
    /**
     * Persist notification model in database if not found
     * @param int $user_id
     * @return Notification
     */
    private function findOrCreateNotificationByUserId($user_id)
    {
        $result = $this->notifRepo->findByUserId($user_id);
        if ($result === null){
            $result = new Notification();
            $result->user_id = $user_id;
            $this->notifRepo->save($result);
        }
        return $result;
    }

    private function findOrCreateNotificationObject(Notification $notification,$object_id,$object_type)
    {
        $result = $this->notifObjRepo->findByNotificationAndObjectIdAndObjectType($notification,$object_id,$object_type);
        if ($result === null){
            $result = new NotificationObject();
            $result->notification_id = $notification->id;
            $result->object_id = $object_id;
            $result->object_type = $object_type;
            $this->notifObjRepo->save($result);
        }
        return $result;
    }

    private function createNotificationChange(NotificationObject $notificationObject,$action,$actor_id,$adverb,$entity_type,$entity_id)
    {
        $notificationChange = new NotificationChange();
        $notificationChange->notification_object_id = $notificationObject->id;
        $notificationChange->actor_id = $actor_id;
        $notificationChange->action = $action;
        $notificationChange->adverb = $adverb;
        $notificationChange->entity_type = $entity_type;
        $notificationChange->entity_id = $entity_id;
        $this->notifChangeRepo->save($notificationChange);

    }

    public function findNotificationChangesByUserIdOrderMostRecent($user_id,$limit)
    {
        $q = NotificationChange::query()
            ->join('notification_objects','notification_changes.notification_object_id','=','notification_objects.id')
            ->join('notifications','notification_objects.notification_id','=','notifications.id')
            ->where('notifications.user_id','=',$user_id)
            ->with(['notificationObject','actor'])
            ->orderBy('notification_changes.id','desc')
            ->limit($limit)
            ->select(['notification_changes.*']);
        $notificationChanges = $this->notifChangeRepo->findAllByQuery($q);
        /** @var AbstractNotification[] $result */
        $result = [];
        foreach($notificationChanges as $notifChange){
            $notifObj = $notifChange->notificationObject;
            $actor = $notifChange->actor;

            if ($notifChange->isActionComment() && $notifObj->isArticle()){
                $comment = $this->commentRepository->findById($notifChange->entity_id);
                if ($comment == null){
                    $this->notifChangeRepo->deleteById($notifChange->id);
                } else {
                    //get article
                    $article = $this->articleRepository->findById($notifObj->object_id);
                    if ($article == null){
                        //then the article is not exist. ignore it
                        $this->notifObjRepo->deleteById($notifObj->id);
                    } else {
                        $datum = new UserCommentArticleNotification($notifChange,$notifObj, $actor, $article, $comment);
                        array_push($result,$datum);
                    }
                }
            } else if ($notifChange->isActionClosed() && $notifObj->isArticle()){
                //get article
                $article = $this->articleRepository->findById($notifObj->object_id);
                if ($article == null){
                    //article doesn't exist. ignore.
                    $this->notifObjRepo->deleteById($notifObj->id);
                } else {
                    $datum = new PanelistCloseSubscribedArticleNotification($notifChange,$notifObj,$actor,$article);
                    array_push($result,$datum);
                }
            } else if ($notifChange->isActionReplied() && $notifObj->isComment()){
                $comment = $this->commentRepository->findById($notifChange->entity_id);
                if ($comment == null){
                    //delete the notification
                    $this->notifChangeRepo->deleteById($notifChange->entity_id);
                } else {
                    //check if parent comment is deleted
                    $parentComment = $this->commentRepository->findById($notifObj->object_id);
                    if ($parentComment == null){
                        //delete the notification object
                        $this->notifObjRepo->deleteById($notifObj->id);
                    } else {
                        //in this context, object id (which replied comment) is not used.
                        //instead, we get the article
                        $article = $this->articleRepository->findById($comment->article_id);
                        if ($article == null){
                            //delete the changes and the object since commented article doesn't exist
                            $this->notifObjRepo->deleteById($notifObj->id);
                            $this->notifChangeRepo->deleteById($notifChange->id);
                        } else {
                            $datum = new UserReplyCommentNotification($notifChange,$notifObj, $actor,$article,$comment);
                            array_push($result,$datum);
                        }
                    }
                }
            }else if ($notifChange->isActionVoted() && $notifObj->isComment()){
                $comment = $this->commentRepository->findById($notifChange->entity_id);
                if ($comment == null){
                    //delete the notification
                    $this->notifChangeRepo->deleteById($notifChange->entity_id);
                } else {
                    $article = $this->articleRepository->findById($comment->article_id);
                    $datum = new UserVoteCommentNotification($notifChange,$notifObj, $actor,$article,$comment);
                    array_push($result,$datum);

                }
            }
        }
        return $result;
    }

    /**
     * Notification when user close article for discussion
     * @param User $actor
     * @param Article $article
     * @return mixed
     */
    public function addPanelistCloseArticle(User $actor, Article $article)
    {
        //find all user that bookmark this article
        $users = $this->userRepository->findAllByArticleBookmarker($article);
        $object_type = NotificationObject::TYPE_ARTICLE;
        $action = NotificationChange::ACTION_CLOSE;
        $adverb = NotificationChange::ADVERB_YOU_FOLLOWED;
        //insert notification to each user
        foreach ($users as $user){
            $this->constructNotification($user->id,$article->id,$object_type,$action,$actor->id,$adverb,null,null);
        }
    }

    public function setAllNotificationChangesToSeen(User $user)
    {
        $this->notifChangeRepo->updateUnseenToSeen($user);
    }
}

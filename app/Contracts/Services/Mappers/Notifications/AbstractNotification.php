<?php

namespace App\Contracts\Services\Mappers\Notifications;


use App\Models\NotificationChange;
use App\Models\NotificationObject;
use App\Models\User;

abstract class AbstractNotification
{
    private $notificationChange;
    private $notificationObject;
    private $actor;

    public function __construct(NotificationChange $notificationChange,NotificationObject $notificationObject,User $actor)
    {
        $this->notificationChange = $notificationChange;
        $this->notificationObject = $notificationObject;
        $this->actor = $actor;
    }

    public function isPanelistClosedFollowedArticle(){
        return $this->notificationChange->isActionClosed() && $this->notificationObject->isArticle()
            && $this->notificationChange->isAdverbYouFollowed();
    }

    public function isUserCommentedOnCreatedArticle(){
        return $this->notificationChange->isActionComment() && $this->notificationObject->isArticle()
            && $this->notificationChange->isAdverbYouCreated();
    }

    public function isUserRepliedComment(){
        return $this->notificationChange->isActionReplied() && $this->notificationObject->isComment()
            && $this->notificationChange->isAdverbYourComment();
    }

    public function isUserVotedComment(){
        return $this->notificationChange->isActionVoted() && $this->notificationObject->isComment()
            && $this->notificationChange->isAdverbYourComment();
    }

    public function getActorName(){
        return $this->actor->name;
    }

    public function getActorPhotoUrl(){
        return $this->actor->photo_url;
    }

    public function getVerb(){
        return $this->notificationChange->action;
    }

    public function getObjectType()
    {
        return $this->notificationObject->object_type;
    }

    public function getAdverb(){
        return $this->notificationChange->adverb;
    }

    public function getTime(){
        return $this->notificationChange->created_at->diffForHumans();
    }

    public function getUserUrl()
    {
        return route('home.panelist',['user_id'=>$this->targetArticle->id]);
    }

    /**
     * Additional info is the notification object that trigger a notification.
     * For example, if user comment 'hello' on a 'hello dummy' article,
     * then additional info will be the 'hello' string
     * @return String
     */
    public abstract function getAdditionalInfo();

    /**
     * The context where the notification is created
     * For example, if user comment 'hello' on a 'hello dummy' article,
     * then the context will be the 'hello dummy'
     * @return String
     */
    public abstract function getContext();

    /**
     * The target of url which is the user will open
     * @return string
     */
    public abstract function getContextUrl();

    /**
     * Return the sentence of the notification. Used if you don't want to create the sentence
     * manually using other methods.
     * @return mixed
     */
    public function getSentence(){
        return $this->getActorName()." ".$this->getVerb()." ".$this->getObjectType()." ".$this->getContext();
    }

}

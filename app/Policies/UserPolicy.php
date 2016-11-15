<?php

namespace App\Policies;


use App\Models\User;

class UserPolicy
{
    public function delete(User $authUser,User $targetUser){
        //not himself and is admin
        //if he is admin, he cannot delete himself,
        if ($authUser->isAdmin()){
            return ($authUser->id != $targetUser->id);
        } else {
            return ($authUser->id == $targetUser->id);
        }
    }

    public function edit(User $authUser,User $targetUser){
        return $authUser->isAdmin() || ($authUser->id == $targetUser->id);
    }

    public function showActivities(User $authUser,User $targetUser){
        //only self can show his/her activity, or admin
        return ($authUser->id == $targetUser->id) || $authUser->isAdmin();
    }

    public function showBookmarkedTopics(User $authUser,User $targetUser){
        //only self can show bookmarked list
        return ($authUser->id == $targetUser->id);
    }

    public function showSubscribedTopics(User $authUser, User $targetUser){
        //only self and (panelist or admin)
        return ($authUser->id == $targetUser->id) || ($authUser->isAdmin() || $authUser->isPanelist());
    }

    public function showModeratedTopics(User $authUser,User $targetUser){
        //only self and (panelist or admin)
        return ($authUser->id == $targetUser->id) && (($authUser->isAdmin() || $authUser->isPanelist()));
    }

    public function addPanelist(User $authUser,User $targetUser){
        //must in him/herself page and is admin
        return $authUser->isAdmin() && ($authUser->id == $targetUser->id);
    }

    public function showVotedTopics(User $authUser,User $user){
        //anyone can
        return true;
    }
    
    public function manageUsers(User $authUser,User $targetUser){
        //must in him/herself page and is admin
        return $authUser->isAdmin() && ($authUser->id == $targetUser->id);
    }

    public function syncSocialMedia(User $authUser,User $user){
        //must him/herself
        return $authUser->id == $user->id;
    }
}
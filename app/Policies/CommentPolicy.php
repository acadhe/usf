<?php

namespace App\Policies;

use App\Contracts\Services\CommentService;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    private $commentService;

    /**
     * Create a new policy instance.
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Check if user can vote a comment
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function vote(User $user,Comment $comment){
        //can vote comment == not voted that comment
        return !$this->commentService->isVoteComment($user, $comment);
    }

    /**
     * Check if user can unvote a comment
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function unvote(User $user,Comment $comment){
        //can unvote == voted that comment before
        return $this->commentService->isVoteComment($user, $comment);
    }
    
    public function delete(User $user,Comment $comment){
        return $user->isAdmin() || $user->id == $comment->user_id;
    }

    public function hide(User $user,Comment $comment){
        return $user->isAdmin();
    }

    public function unhide(User $user,Comment $comment){
        return $user->isAdmin();
    }
}

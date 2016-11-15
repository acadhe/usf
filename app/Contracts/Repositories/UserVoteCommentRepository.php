<?php

namespace App\Contracts\Repositories;



use App\Models\Comment;
use App\Models\User;
use App\Models\UserVoteComment;

interface UserVoteCommentRepository
{
    /**
     * @param UserVoteComment $userVoteComment
     * @return boolean
     */
    public function save(UserVoteComment $userVoteComment);

    /**
     * @param UserVoteComment $userVoteComment
     * @return boolean
     */
    public function delete(UserVoteComment $userVoteComment);

    public function findByUserAndComment(User $user,Comment $comment);
}
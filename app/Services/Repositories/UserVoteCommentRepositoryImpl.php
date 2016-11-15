<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\UserVoteCommentRepository;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserVoteComment;

class UserVoteCommentRepositoryImpl implements UserVoteCommentRepository
{

    public function save(UserVoteComment $userVoteComment)
    {
        return $userVoteComment->save();
    }

    public function delete(UserVoteComment $userVoteComment)
    {
        return $userVoteComment->delete();
    }

    public function findByUserAndComment(User $user,Comment $comment)
    {
        return UserVoteComment::where('user_id','=',$user->id)->where('comment_id','=',$comment->id)->first();
    }
}
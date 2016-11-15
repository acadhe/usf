<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\CommentRepository;
use App\Models\Article;
use App\Models\Comment;

class CommentRepositoryImpl implements CommentRepository
{

    public function updateVotesCount(Comment $comment)
    {
        $comment->votes_count = $comment->userVoteComments()->count();
        $this->save($comment);
    }

    public function save(Comment $comment)
    {
        return $comment->save();
    }

    public function delete(Comment $comment)
    {
        return $comment->delete();
    }


    public function findById($comment_id)
    {
        return Comment::where('id','=',$comment_id)->first();
    }

    public function countByArticleAndSupport(Article $article, $support)
    {
        return $article->comments()->where('support','=',$support)->count();
    }

    public function findAllByArticleOrderByDescWithUser(Article $article,$order_col = null)
    {
        $q = $article->comments();
        if ($order_col !== null){
            $q->orderBy($order_col,'desc');
        }
        return $q->with(['user'])->get();
    }

    public function updateCommentsCount(Article $article)
    {
        $article->comments_count = $article->comments()->count();
        $article->save();
        return $article->comments_count;
    }

    public function findAll()
    {
        return Comment::all();
    }
}
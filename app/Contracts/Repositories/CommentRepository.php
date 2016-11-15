<?php

namespace App\Contracts\Repositories;


use App\Models\Article;
use App\Models\Comment;

interface CommentRepository
{
    public function updateVotesCount(Comment $comment);

    public function findAllByArticleOrderByDescWithUser(Article $article,$desc_col);

    public function countByArticleAndSupport(Article $article,$support);

    public function updateCommentsCount(Article $article);

    public function save(Comment $comment);

    public function delete(Comment $comment);
    
    public function findById($comment_id);

    /**
     * @return Comment[]
     */
    public function findAll();
}
<?php

namespace App\Contracts\Services;


use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

interface CommentService
{
    /**
     * @param $article_id
     * @param string $desc_order
     * @return Mappers\NestedComment[]
     */
    public function getNestedCommentsByArticleWithUser(Article $article_id, $desc_order = null);

    /**
     * @param Article $article
     * @param User $user
     * @param $content
     * @param $support
     * @param Comment $repliedComment
     * @return Comment
     */
    public function postComment(Article $article, User $user, $content, $support,Comment $repliedComment = null);

    public function hideComment(Comment $comment);

    public function unhideComment(Comment $comment);

    public function voteComment(User $user,Comment $comment);

    public function unvoteComment(User $user, Comment $comment);

    /**
     * Check if user votes a comment
     * @param User $user
     * @param Comment $comment
     * @return boolean
     */
    public function isVoteComment(User $user,Comment $comment);

}
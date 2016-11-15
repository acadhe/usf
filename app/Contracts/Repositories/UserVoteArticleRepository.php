<?php

namespace App\Contracts\Repositories;


use App\Models\Article;
use App\Models\User;
use App\Models\UserVoteArticle;

interface UserVoteArticleRepository
{
    public function countArticleVote(Article $article);

    /**
     * Determine if user votes an article
     * @param User $user
     * @param Article $article
     * @return boolean
     */
    public function isVote(User $user,Article $article);

    /**
     * @param User $user
     * @param Article $article
     * @return UserVoteArticle
     */
    public function findOneByUserAndArticle(User $user,Article $article);

    public function delete(UserVoteArticle $userVoteArticle);

    public function save(UserVoteArticle $userVoteArticle);
}
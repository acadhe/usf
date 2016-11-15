<?php

namespace App\Contracts\Services;


use App\Models\Article;
use App\Models\User;

interface UserVoteArticleService
{
    public function vote(User $user,Article $article);

    public function unvote(User $user,Article $article);

}
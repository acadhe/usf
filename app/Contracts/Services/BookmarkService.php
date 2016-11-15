<?php

namespace App\Contracts\Services;


use App\Models\Article;
use App\Models\User;

interface BookmarkService
{
    public function isArticleBookmarked(Article $article,User $user);

    public function markArticle(Article $article,User $user);

    public function unmarkArticle(Article $article,User $user);
}
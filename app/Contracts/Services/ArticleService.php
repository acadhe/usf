<?php

namespace App\Contracts\Services;

use App\Http\Requests\Articles\CreateArticleRequest;
use App\Http\Requests\Articles\UpdateArticleRequest;
use App\Models\Article;
use App\Models\User;

interface ArticleService
{
    public function createArticleFromRequest(CreateArticleRequest $request,User $creator);

    public function updateArticle(Article $article,UpdateArticleRequest $request);

    /**
     * @param Article $article
     * @return int result of total shares count
     */
    public function updateShareCount(Article $article);

    public function closeArticle(Article $article, User $actor, $summary);

    public function publishArticle(Article $article);

    /**
     * @param User $user
     * @return Article
     */
    public function createBlankArticle(User $user);
}
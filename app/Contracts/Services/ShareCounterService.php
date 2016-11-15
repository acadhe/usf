<?php

namespace App\Contracts\Services;


use App\Models\Article;

interface ShareCounterService
{
    public function getArticleShareCountOfTwitter(Article $article);
    
    public function getArticleShareCountOfFacebook(Article $article);
}
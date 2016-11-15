<?php

namespace App\Contracts\Services;


use App\Models\Article;

interface SocialMediaService
{
    function facebookShareArticle(Article $article);

    function twitterShareArticle(Article $article);

    function googlePlusShareArticle(Article $article);
}
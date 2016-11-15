<?php

namespace App\Services\Services;


use App\Contracts\Services\SocialMediaService;
use App\Models\Article;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class SocialMediaServiceImpl implements SocialMediaService
{
    private $fb_app_id;
    private $fb_app_secret;

    function __construct()
    {
        $this->fb_app_id = config('auth.facebook.app_id');
        $this->fb_app_secret = config('auth.facebook.app_secret');

    }

    function facebookShareArticle(Article $article)
    {
        $content = substr(strip_tags($article->content),0,200);
        $qs = "app_id=".$this->fb_app_id."&display=popup&caption=".urlencode($article->title)."&link=".urlencode(route('article.read',['id'=>$article->id]))."&redirect_uri=".Request::url()."&description=".$content;
        if ($article->header_image_url != ''){
            $qs .= "&picture={$article->header_image_url}";
        }
        $url = URL::to("https://www.facebook.com/dialog/feed?".$qs);
        return $url;
    }

    function twitterShareArticle(Article $article)
    {
        $qs = "url=".urlencode(route('article.read',['id'=>$article->id]));
        $url = URL::to("https://twitter.com/intent/tweet?".$qs);
        return $url;
    }

    function googlePlusShareArticle(Article $article)
    {
        $qs = "url=".urlencode(route('article.read',['article_id'=>$article->id]))."&h1=id";
        $url = URL::to("https://plus.google.com/share?".$qs);
        return $url;
    }
}
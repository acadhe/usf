<?php

namespace App\Services\Services;


use App\Contracts\Services\ShareCounterService;
use App\Models\Article;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ShareCounterServiceImpl implements ShareCounterService
{
    /**
     * Nanti ini diganti dengan url production
     * @param Article $article
     * @return string
     */
    private function articleUrl(Article $article){
        return "http://www.twitter.com";
    }

    public function getArticleShareCountOfTwitter(Article $article)
    {
        $client = new Client();
        $request = new Request('GET',"http://opensharecount.com/count.json?url=".$this->articleUrl($article));
        $response = $client->send($request);
        $json = \GuzzleHttp\json_decode($response->getBody());
        return $json->count;
    }

    public function getArticleShareCountOfFacebook(Article $article)
    {
        $client = new Client();
        $request = new Request('GET', "http://graph.facebook.com/?id=".$this->articleUrl($article));
        $response = $client->send($request);
        $json = \GuzzleHttp\json_decode($response->getBody());
        return $json->shares;
    }
}
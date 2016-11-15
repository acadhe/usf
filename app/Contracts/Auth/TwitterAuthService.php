<?php

namespace App\Contracts\Auth;


use App\Models\Article;
use App\Models\User;
use App\Services\Auth\Exceptions\TwitterEmailNotProvidedException;

interface TwitterAuthService
{
    public function shareArticle(Article $article,User $actor);

    public function setOAuthTokenAndVerifier($oauth_token,$oauth_verifier);

    /**
     * Redirect user ke halaman otorisasi twitter
     * @return string
     */
    public function createRedirectUrl();

    /**
     * Cek apakah oauth token di session sesuai dengan return dari twitter
     * @param $oauth_token
     * @return mixed
     */
    public function validateOAuthToken($oauth_token);

    /**
     * Login user berdasarkan oauth token di session
     * @return mixed
     * @throws TwitterEmailNotProvidedException
     */
    public function authenticate($oauth_token,$oauth_token_sec);

    /**
     * @param $oauth_token
     * @param $oauth_token_secret
     * @param $oauth_verifier
     * @return array
     */
    public function executeAccessToken($oauth_token,$oauth_token_secret,$oauth_verifier);

    /**
     * @param $oauth_token
     * @param $oauth_token_secret
     * @return object
     */
    public function executeVerifyCredentials($oauth_token,$oauth_token_secret);

    public function createUserFromSession($email);

    public function storeTwitterData($twitter_id,$name, $username);

    /**
     * Sync existing user with current twitter data
     * @param User $user
     * @param $twitter_data
     * @param $oauth_token
     * @param $oauth_token_sec
     * @return User modified user
     */
    public function syncAccount(User $user, $twitter_data,$oauth_token,$oauth_token_sec);

    public function getOAuthTokenSecret();

    public function setOAuthTokenSecret($new);

    public function getOAuthToken();

    public function setOAuthToken($new);

    public function getAfterCallbackURL();

    public function setAfterCallbackURL($url);

    public function getAfterLoginURL();

    public function setAfterLoginURL($url);

    public function getAfterSyncAccountURL();

    public function setAfterSyncAccountURL($url);

    
}
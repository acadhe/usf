<?php

namespace App\Services\Auth;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Contracts\Auth\TwitterAuthService;
use App\Contracts\Repositories\UserRepository;
use App\Models\Article;
use App\Models\User;
use App\Services\Auth\Exceptions\TwitterEmailNotProvidedException;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class TwitterAuthServiceImpl implements TwitterAuthService
{
    private $consumer_key;
    private $consumer_secret;
    private $oauth_callback;

    private $session;
    private $userRepository;

    const TWITTER_ID_SESSION_KEY = 'twitter_id_session_key';
    const TWITTER_NAME_SESSION_KEY = "twitter_name_session_key";
    const TWITTER_USERNAME_SESSION_KEY = 'twitter_username_session_key';
    const OAUTH_TOKEN_SESSION_KEY = 'twitter_oauth_token_session_key';
    const OAUTH_TOKEN_SESSION_TOKEN_SECRET_KEY = 'twitter_oauth_token_session_secret_key';
    const OAUTH_VERIFIER_SESSION_KEY = "twitter_oauth_verifier_key";
    const AFTER_CALLBACK_URL_KEY = "twitter_after_callback_url_session_key";
    const AFTER_LOGIN_URL_KEY = "twitter_after_login_url_session_key";
    const AFTER_SYNC_ACCOUNT_URL_KEY = "twitter_after_sync_account_url_key";


    public function __construct(Store $session,UserRepository $userRepository)
    {
        $this->consumer_key = config('auth.twitter.consumer_key');
        $this->consumer_secret = config('auth.twitter.consumer_secret');
        $this->oauth_callback = Request::root().config('auth.twitter.oauth_callback');

        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    public function validateOAuthToken($oauth_token)
    {
        return $oauth_token == $this->getOAuthToken();
    }

    public function createRedirectUrl()
    {
        $connection = new TwitterOAuth($this->consumer_key,$this->consumer_secret);
        $this->createRequestToken();
        return $connection->url('oauth/authorize',['oauth_token' => $this->getOAuthToken()]);
    }

    public function createUserFromSession($email){
        $auth_twitter_id = $this->session->get(self::TWITTER_ID_SESSION_KEY);
        $auth_twitter_username = $this->session->get(self::TWITTER_USERNAME_SESSION_KEY);
        $user = new User();
        $user->email = $email;
        $user->name = $this->session->get(self::TWITTER_NAME_SESSION_KEY);
        $user->twitter_id = $auth_twitter_id;
        $user->type = User::TYPE_USER;
        $user->twitter_name = $auth_twitter_username;
        $this->userRepository->save($user);
        return $user;
    }

    public function storeTwitterData($twitter_id,$name, $username){
        $this->session->set(self::TWITTER_ID_SESSION_KEY,$twitter_id);
        $this->session->set(self::TWITTER_USERNAME_SESSION_KEY,$username);
        $this->session->set(self::TWITTER_NAME_SESSION_KEY,$name);
    }

    public function executeAccessToken($oauth_token,$oauth_token_sec,$oauth_verifier){
        $connection = new TwitterOAuth($this->consumer_key,$this->consumer_secret, $oauth_token,$oauth_token_sec);
        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $oauth_verifier]);
        return $access_token;
    }

    public function executeVerifyCredentials($oauth_token, $oauth_token_sec)
    {
        $connection = new TwitterOAuth($this->consumer_key,$this->consumer_secret, $oauth_token,$oauth_token_sec);
        $twitter_data = $connection->get("account/verify_credentials",['include_email'=>'true']);
        return $twitter_data;
    }

    /**
     * @throws TwitterEmailNotProvidedException
     */
    public function authenticate($oauth_token,$oauth_token_sec)
    {
        //ambil data
        $twitter_data = $this->executeVerifyCredentials($oauth_token,$oauth_token_sec);

        //simpan user ke db kalo belum terdaftar
        $user = $this->userRepository->findByTwitterId($twitter_data->id);
        if ($user === null){
            //try by email
            if ($twitter_data->email == null){
                throw new TwitterEmailNotProvidedException($twitter_data->id,$twitter_data->name,$twitter_data->screen_name);
            }
            $user = $this->userRepository->findByEmail($twitter_data->email);
            if ($user === null){
                //user belum ada. bikin user baru.
                $user = new User();
                $user->name = $twitter_data->name;
                $user->type = User::TYPE_USER;
                $user->email = $twitter_data->email;
            }
        }
        $this->syncAccount($user,$twitter_data,$oauth_token,$oauth_token_sec);
        return $user;
    }

    private function createRequestToken()
    {
        $connection = new TwitterOAuth($this->consumer_key,$this->consumer_secret);
        $result = $connection->oauth('oauth/request_token', array('oauth_callback' =>  $this->oauth_callback));
        $this->setOAuthToken($result['oauth_token']);
        $this->setOAuthTokenSecret($result['oauth_token_secret']);
    }

    public function setOAuthToken($new)
    {
        $this->session->set(self::OAUTH_TOKEN_SESSION_KEY,$new);
    }

    public function setOAuthTokenSecret($new)
    {
        $this->session->set(self::OAUTH_TOKEN_SESSION_TOKEN_SECRET_KEY,$new);
    }

    public function getOAuthToken()
    {
        return $this->session->get(self::OAUTH_TOKEN_SESSION_KEY);
    }

    public function getOAuthTokenSecret()
    {
        return $this->session->get(self::OAUTH_TOKEN_SESSION_TOKEN_SECRET_KEY);
    }

    public function getAfterCallbackURL()
    {
        return $this->session->get(self::AFTER_CALLBACK_URL_KEY);
    }

    public function setAfterCallbackURL($url)
    {
        $this->session->set(self::AFTER_CALLBACK_URL_KEY,$url);
    }

    public function getAfterLoginURL(){
        return $this->session->get(self::AFTER_LOGIN_URL_KEY);
    }

    public function setAfterLoginURL($url){
        $this->session->set(self::AFTER_LOGIN_URL_KEY,$url);
    }

    private function getOAuthVerifier(){
        return $this->session->get(self::OAUTH_VERIFIER_SESSION_KEY);
    }

    private function setOAuthVerifier($oauth_verifier){
        $this->session->set(self::OAUTH_VERIFIER_SESSION_KEY,$oauth_verifier);
    }


    public function setOAuthTokenAndVerifier($oauth_token, $oauth_verifier)
    {
        $this->setOAuthToken($oauth_token);
        $this->setOAuthVerifier($oauth_verifier);
    }

    /**
     * Sync existing user with current twitter data
     * @param User $user
     * @param $twitter_data
     * @return User modified user
     */
    public function syncAccount(User $user, $twitter_data,$oauth_token,$oauth_token_sec)
    {
        $user->twitter_id = $twitter_data->id;
        $user->twitter_name = $twitter_data->screen_name;
        $user->twitter_oauth_token = $oauth_token;
        $user->twitter_oauth_token_secret = $oauth_token_sec;
        if ($user->photo_url == null){
            $user->photo_url = $twitter_data->profile_image_url_https;
        }
        $this->userRepository->save($user);
        return $user;
    }

    public function getAfterSyncAccountURL()
    {
        return $this->session->get(self::AFTER_SYNC_ACCOUNT_URL_KEY);
    }

    public function setAfterSyncAccountURL($url)
    {
        $this->session->set(self::AFTER_SYNC_ACCOUNT_URL_KEY,$url);
    }

    public function shareArticle(Article $article, User $actor)
    {
        //get most recent oauth token and secret from user
        $user = $this->userRepository->findById($actor->id);
        $oauth_token = $user->twitter_oauth_token;
        $oauth_token_sec = $user->twitter_oauth_token_secret;
        $connection = new TwitterOAuth($this->consumer_key,$this->consumer_secret, $oauth_token,$oauth_token_sec);
        $connection->post("statuses/update",['status' => route('article.read',['article_id'=>$article->id])]);
    }
}
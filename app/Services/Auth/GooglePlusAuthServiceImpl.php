<?php

namespace App\Services\Auth;


use App\Contracts\Auth\GooglePlusAuthService;
use App\Contracts\Repositories\UserRepository;
use App\Models\User;
use Google_Client;
use Google_Service_Plus;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class GooglePlusAuthServiceImpl implements GooglePlusAuthService
{
    private $client_id;
    private $client_secret;
    private $oauth_callback;
    private $userRepository;
    private $session;

    const GPLUS_AFTER_CALLBACK_URL_KEY = "gplus_after_callback_url_key";
    const GPLUS_AFTER_SYNC_ACCOUNT_URL_KEY = "gplus_after_sync_url_key";
    const GPLUS_ACCESS_TOKEN_KEY = "gplus_access_token_key";
    const GPLUS_AFTER_LOGIN_URL_KEY = "gplus_after_login_url_key";
    const GPLUS_ID_TOKEN_KEY = "gplus_id_token_key";


    public function __construct(UserRepository $userRepository,Store $session)
    {
        $this->client_id = config('auth.google_plus.client_id');
        $this->client_secret = config('auth.google_plus.client_secret');
        $this->oauth_callback = Request::root().config('auth.google_plus.oauth_callback');
        $this->session = $session;
        $this->userRepository = $userRepository;
    }


    /**
     * @param string $id_token token gotten from ajax request in client-side
     * @return mixed
     */
    public function authenticate($id_token)
    {
        $result = $this->executeVerifyIDToken($id_token);
        $user = $this->userRepository->findByGooglePlusId($result['sub']);
        if ($user === null){
            //try via email
            $user = $this->userRepository->findByEmail($result['email']);
            if ($user === null){
                $user = new User();
                $user->name = $result['name'];
                $user->email = $result['email'];
            }
            $user->type = User::TYPE_USER;
            $this->userRepository->save($user);
        }
        $this->syncAccount($user,$result);
        return $user;
    }

    public function executeVerifyIDToken($id_token){
        $client = $this->createGoogleClient();
        $result = $client->verifyIdToken($id_token);
        return $result;
    }

    public function createRedirectUrl()
    {
        $client = $this->createGoogleClient();
        $client->setScopes(['email','profile']);
        return $client->createAuthUrl();
    }

    private function createGoogleClient(){
        $client = new Google_Client();
        $client->setClientId($this->client_id);
        $client->setClientSecret($this->client_secret);
        $client->setRedirectUri($this->oauth_callback);
        $client->addScope(Google_Service_Plus::PLUS_ME);
        return $client;
    }

    public function setAfterCallbackURL($url)
    {
        $this->session->set(self::GPLUS_AFTER_CALLBACK_URL_KEY,$url);
    }

    public function getAfterCallbackURL()
    {
        return $this->session->get(self::GPLUS_AFTER_CALLBACK_URL_KEY);
    }

    public function setAfterLoginURL($url)
    {
        $this->session->set(self::GPLUS_AFTER_LOGIN_URL_KEY,$url);
    }

    public function getAfterLoginURL()
    {
        return $this->session->get(self::GPLUS_AFTER_LOGIN_URL_KEY);
    }

    public function setAfterSyncAccountURL($url)
    {
        $this->session->set(self::GPLUS_AFTER_SYNC_ACCOUNT_URL_KEY,$url);
    }

    public function getAfterSyncAccountURL()
    {
        return $this->session->get(self::GPLUS_AFTER_SYNC_ACCOUNT_URL_KEY);
    }

    public function syncAccount(User $user, $gplus_data)
    {
        $user->google_plus_id = $gplus_data['sub'];
        $user->google_plus_name = $gplus_data['name'];
        if ($user->photo_url == null){
            $user->photo_url = $gplus_data['picture'];
        }
        $this->userRepository->save($user);
        return $user;
    }

    public function setAccessToken($token)
    {
        $this->session->set(self::GPLUS_ACCESS_TOKEN_KEY,$token);
    }

    public function getAccessToken()
    {
        return $this->session->get(self::GPLUS_ACCESS_TOKEN_KEY);
    }

    public function executeFetchAccessToken($auth_code)
    {
        $client = $this->createGoogleClient();
        $result = $client->authenticate($auth_code);
        return $result;
    }

    public function getIDToken()
    {
        return $this->session->get(self::GPLUS_ID_TOKEN_KEY);
    }

    public function setIDToken($id_token)
    {
        $this->session->set(self::GPLUS_ID_TOKEN_KEY,$id_token);
    }
}
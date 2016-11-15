<?php

namespace App\Services\Auth;


use App\Contracts\Auth\FacebookAuthService;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\UserService;
use App\Exceptions\FacebookAuthLoginException;
use App\Models\User;
use App\Services\Auth\Exceptions\FacebookEmailNotProvidedException;
use Carbon\Carbon;
use DateTime;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class FacebookAuthServiceImpl implements FacebookAuthService
{
    private $app_id;
    private $app_secret;
    private $oauth_callback;

    private $session;

    const FB_ACCESS_TOKEN_KEY = "fb_access_token_key";
    const FB_ID_SESSION_KEY = "fb_id_session_key";
    const FB_NAME_SESSION_KEY = "fb_name_session_key";
    const FB_ACCESS_TOKEN_EXPIRES_AT_KEY = "fb_access_token_expires_at_key";
    const AFTER_CALLBACK_URL_KEY = "fb_after_callback_url_key";
    const AFTER_LOGIN_URL_KEY = "fb_after_login_url_key";
    const AFTER_SYNC_ACCOUNT_URL_KEY = "fb_after_sync_account_url_key";

    private $userRepository;

    public function __construct(Store $session,UserRepository $userRepository)
    {
        $this->app_id = config('auth.facebook.app_id');
        $this->app_secret = config('auth.facebook.app_secret');
        $this->oauth_callback = Request::root().config('auth.facebook.oauth_callback');
        $this->userRepository  = $userRepository;

        $this->session = $session;
        //supaya fb bisa nyimpen data session
        if(!session_id()) {
            session_start();
        }
    }

    /**
     * Redirect user ke halaman otorisasi twitter
     * @return string
     */
    public function createRedirectUrl()
    {
        $fb = new Facebook(['app_id' => $this->app_id,'app_secret'=>$this->app_secret]);
        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl($this->oauth_callback, $permissions);

        return $loginUrl;
    }

    /**
     * Cek apakah oauth token di session sesuai dengan return dari twitter
     * @return mixed
     * @throws FacebookAuthLoginException
     */
    public function extractLongLivedAccessToken()
    {
        $fb = new Facebook(['app_id' => $this->app_id,'app_secret'=>$this->app_secret]);
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            throw new FacebookAuthLoginException($e->getMessage());
        } catch(FacebookSDKException $e) {
            throw new FacebookAuthLoginException($e->getMessage());
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                throw new FacebookAuthLoginException($helper->getError());
            } else {
                throw new FacebookAuthLoginException("Bad request");
            }
        }

        //get long lived access token
        $oAuth2Client = $fb->getOAuth2Client();
        if (! $accessToken->isLongLived()) {
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
                throw new FacebookAuthLoginException("Error getting long-lived access token: " . $helper->getMessage());
            }
        }
        $this->setAccessToken($accessToken);
        return $accessToken;
    }

    /**
     * Login user berdasarkan oauth token di session
     * @throws FacebookEmailNotProvidedException
     */
    public function authenticate($access_token,DateTime $accessTokenExpiresAt)
    {
        $fb_data = $this->executeMe($access_token);
        $user = $this->userRepository->findByFacebookId($fb_data['id']);
        //if new user
        if ($user === null){
            if (!isset($fb_data['email']) || $fb_data['email'] == null){
                throw new FacebookEmailNotProvidedException($fb_data['id'],$fb_data['name']);
            }
            //try with email
            $user = $this->userRepository->findByEmail($fb_data['email']);
            //if still null then it is new user
            if ($user === null){
                $user = new User();
                $user->type = User::TYPE_USER;
                $user->name = $fb_data['name'];
                $user->email = $fb_data['email'];
            }
        }
        $this->syncAccount($user,$fb_data,$access_token,$accessTokenExpiresAt);
        return $user;
    }

    public function createLogoutUrl()
    {
        $fb = new Facebook(['app_id' => $this->app_id,'app_secret'=>$this->app_secret]);
        $helper = $fb->getRedirectLoginHelper();

        $logoutUrl = $helper->getLogoutUrl($this->getAccessToken(),url(route('login')));
        return $logoutUrl;
    }

    public function setAccessToken($new){
        $this->session->set(self::FB_ACCESS_TOKEN_KEY,$new);
    }

    public function getAccessToken(){
        return $this->session->get(self::FB_ACCESS_TOKEN_KEY);
    }

    public function storeFacebookData($fb_id, $name)
    {
        $this->session->set(self::FB_ID_SESSION_KEY,$fb_id);
        $this->session->set(self::FB_NAME_SESSION_KEY,$name);
    }

    public function createUserFromSession($email)
    {
        $fbid = $this->session->get(self::FB_ID_SESSION_KEY);
        $fbname = $this->session->get(self::FB_NAME_SESSION_KEY);
        $user = new User();
        $user->facebook_id = $fbid;
        $user->facebook_name = $fbname;
        $user->name = $fbname;
        $user->email = $email;
        $user->type = User::TYPE_USER;
        $this->userRepository->save($user);
        return $user;
    }

    public function setAfterCallbackURL($url)
    {
        $this->session->set(self::AFTER_CALLBACK_URL_KEY,$url);
    }

    public function getAfterCallbackUrl()
    {
        return  $this->session->get(self::AFTER_CALLBACK_URL_KEY);
    }

    public function setAfterLoginURL($url)
    {
        $this->session->set(self::AFTER_LOGIN_URL_KEY,$url);
    }

    public function getAfterLoginURL()
    {
        return $this->session->get(self::AFTER_LOGIN_URL_KEY);
    }

    public function setAfterSyncAccountURL($url)
    {
        $this->session->set(self::AFTER_SYNC_ACCOUNT_URL_KEY,$url);
    }

    public function getAfterSyncAccountURL()
    {
        return $this->session->get(self::AFTER_SYNC_ACCOUNT_URL_KEY);
    }

    /**
     * Get user data based on access token
     * @param $access_token
     * @return array
     */
    public function executeMe($access_token)
    {
        $fb = new Facebook(['app_id' => $this->app_id,'app_secret'=>$this->app_secret]);
        $response = $fb->get('/me?fields=id,name,email,picture', $access_token);
        $fb_data = $response->getDecodedBody();
        return $fb_data;
    }

    public function executeUserIdPicture($fbid,$access_token)
    {
        $fb = new Facebook(['app_id' => $this->app_id,'app_secret'=>$this->app_secret]);
        $response = $fb->get("{$fbid}/picture?redirect=false&type=large",$access_token);
        return $response->getDecodedBody();
    }

    public function setAccessTokenExpiresAt(DateTime $dateTime)
    {
        $this->session->set(self::FB_ACCESS_TOKEN_EXPIRES_AT_KEY,$dateTime);
    }

    /**
     * @return DateTime
     */
    public function getAccessTokenExpiresAt()
    {
        return $this->session->get(self::FB_ACCESS_TOKEN_EXPIRES_AT_KEY);
    }

    /**
     * Sync facebook data with existing user
     * @param User $user
     * @param $fb_data
     * @param $access_token
     * @param DateTime $accessTokenExpiresAt
     * @return User
     */
    public function syncAccount(User $user, $fb_data, $access_token, DateTime $accessTokenExpiresAt)
    {
        $user->facebook_id = $fb_data['id'];
        $user->facebook_name = $fb_data['name'];
        $user->facebook_access_token = $access_token;
        $user->facebook_access_token_expires_at = Carbon::instance($accessTokenExpiresAt)->timezone(config('app.timezone'));
        //if user doesn't have initial pp, set the pp based on facebook.
        if ($user->photo_url == null){
            $pp_fb_data = $this->executeUserIdPicture($fb_data['id'],$access_token);
            $user->photo_url = $pp_fb_data['data']['url'];
        }
        $this->userRepository->save($user);
        return $user;
    }
}
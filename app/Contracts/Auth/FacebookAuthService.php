<?php

namespace App\Contracts\Auth;

use App\Exceptions\FacebookAuthLoginException;
use App\Models\User;
use DateTime;
use Facebook\Authentication\AccessToken;

interface FacebookAuthService
{
    /**
     * Redirect user ke halaman otorisasi fb
     * @return string
     */
    public function createRedirectUrl();

    /**
     * Cek apakah oauth token di session sesuai dengan return dari fb
     * @return AccessToken
     * @throws FacebookAuthLoginException
     */
    public function extractLongLivedAccessToken();

    /**
     * Login user berdasarkan oauth token di session
     * @param $access_token
     * @param DateTime $accessTokenExpiresAt
     * @return User
     */
    public function authenticate($access_token,DateTime $accessTokenExpiresAt);

    /**
     * Sync facebook data with existing user
     * @param User $user
     * @param $fb_data
     * @param $access_token
     * @param DateTime $access_token_expired_at
     * @return User
     */
    public function syncAccount(User $user,$fb_data,$access_token,DateTime $access_token_expired_at);

    /**
     * Get user data based on access token
     * @param $access_token
     * @return array
     */
    public function executeMe($access_token);

    public function executeUserIdPicture($fbid,$access_token);

    public function createLogoutUrl();

    public function storeFacebookData($fb_id,$name);

    public function createUserFromSession($email);

    public function setAfterCallbackURL($url);

    public function getAfterCallbackUrl();

    public function setAfterLoginURL($url);

    public function getAfterLoginURL();

    public function setAfterSyncAccountURL($url);

    public function getAfterSyncAccountURL();

    /**
     * @param string $new
     */
    public function setAccessToken($new);

    /**
     * @return string
     */
    public function getAccessToken();

    public function setAccessTokenExpiresAt(DateTime $dateTime);

    /**
     * @return DateTime
     */
    public function getAccessTokenExpiresAt();
}
<?php

namespace App\Contracts\Auth;


use App\Models\User;

interface GooglePlusAuthService
{
    public function createRedirectUrl();

    public function executeVerifyIDToken($id_token);

    public function executeFetchAccessToken($auth_code);

    /**
     * @param string $id_token token gotten from ajax request in client-side
     * @return mixed
     */
    public function authenticate($id_token);

    public function syncAccount(User $user,$gplus_data);

    public function setAccessToken($token);

    public function getAccessToken();

    public function getIDToken();

    public function setIDToken($id_token);

    public function setAfterCallbackURL($url);

    public function getAfterCallbackURL();

    public function setAfterLoginURL($url);

    public function getAfterLoginURL();

    public function setAfterSyncAccountURL($url);

    public function getAfterSyncAccountURL();
}
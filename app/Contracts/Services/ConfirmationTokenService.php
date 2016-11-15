<?php

namespace App\Contracts\Services;


use App\Models\ConfirmationToken;
use App\Models\FacebookIntegration;
use App\Models\User;

interface ConfirmationTokenService
{
    /**
     * @param User $user
     * @param $facebook_id
     * @param $facebook_name
     * @param $facebook_access_token
     * @param $facebook_access_token_expires_at
     * @param $facebook_photo_url
     * @return ConfirmationToken
     */
    public function createFacebookConfirmationToken(User $user, $facebook_id, $facebook_name, $facebook_access_token, $facebook_access_token_expires_at, $facebook_photo_url);

    /**
     * @param User $user
     * @param $twitter_id
     * @param $twitter_name
     * @param $twitter_oauth_token
     * @param $twitter_oauth_token_secret
     * @param $twitter_photo_url
     * @return ConfirmationToken
     */
    public function createTwitterConfirmationToken(User $user, $twitter_id,$twitter_name,$twitter_oauth_token,$twitter_oauth_token_secret,$twitter_photo_url);

    /**
     * Create confirmation token
     * @param User $user
     * @param $media
     * @return ConfirmationToken
     */
    public function createConfirmationToken(User $user,$media);

    /**
     * Set the verified value in User model and delete the token from database
     * @param ConfirmationToken $confirmationToken
     */
    public function acceptConfirmationToken(ConfirmationToken $confirmationToken);

    /**
     * Delete the token from database and nullify all social media data from current user
     * @param ConfirmationToken $confirmationToken
     */
    public function denyConfirmationToken(ConfirmationToken $confirmationToken);

    /**
     * Check whether this token can be used.
     * @param ConfirmationToken $confirmationToken
     * @return bool
     */
    public function isExpired(ConfirmationToken $confirmationToken);
}
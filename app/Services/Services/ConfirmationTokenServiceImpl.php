<?php

namespace App\Services\Services;


use App\Contracts\Repositories\ConfirmationTokenRepository;
use App\Contracts\Repositories\FacebookIntegrationRepository;
use App\Contracts\Repositories\TwitterIntegrationRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\ConfirmationTokenService;
use App\Models\ConfirmationToken;
use App\Models\FacebookIntegration;
use App\Models\TwitterIntegration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ConfirmationTokenServiceImpl implements ConfirmationTokenService
{
    const VALID_UNTIL_HOURS = 24;

    private $confirmationTokenRepository;
    private $facebookIntegrationRepository;
    private $twitterIntegrationRepository;
    private $userRepository;

    public function __construct(ConfirmationTokenRepository $confirmationTokenRepository,UserRepository $userRepository,TwitterIntegrationRepository $twitterIntegrationRepository,FacebookIntegrationRepository $facebookIntegrationRepository)
    {
        $this->userRepository = $userRepository;
        $this->twitterIntegrationRepository = $twitterIntegrationRepository;
        $this->facebookIntegrationRepository = $facebookIntegrationRepository;
        $this->confirmationTokenRepository = $confirmationTokenRepository;
    }

    public function createConfirmationToken(User $user, $media)
    {
        $confirmationToken = new ConfirmationToken();
        $confirmationToken->user()->associate($user);
        $confirmationToken->media = $media;
        $confirmationToken->valid_until = Carbon::now()->addHour(self::VALID_UNTIL_HOURS);
        $confirmationToken->token = Str::random(200);
        $this->confirmationTokenRepository->save($confirmationToken);
        return $confirmationToken;
    }

    public function acceptConfirmationToken(ConfirmationToken $confirmationToken)
    {
        $user = $confirmationToken->user;
        if ($confirmationToken->isFacebook()){
            $fbData = $this->facebookIntegrationRepository->findByConfirmationToken($confirmationToken);
            $user->facebook_id = $fbData->facebook_id;
            $user->facebook_name = $fbData->facebook_name;
            $user->facebook_access_token = $fbData->facebook_access_token;
            $user->facebook_access_token_expires_at = $fbData->facebook_access_token_expires_at;
            if ($user->photo_url == ''){
                $user->photo_url = $fbData->facebook_photo_url;
            }
        } else if ($confirmationToken->isTwitter()){
            $twitterData = $this->twitterIntegrationRepository->findByConfirmationToken($confirmationToken);
            $user->twitter_id = $twitterData->twitter_id;
            $user->twitter_name = $twitterData->twitter_name;
            $user->twitter_oauth_token = $twitterData->twitter_oauth_token;
            $user->twitter_oauth_token_secret = $twitterData->twitter_oauth_token_secret;
            if ($user->photo_url == ''){
                $user->photo_url = $twitterData->twitter_photo_url;
            }
        }
        $this->userRepository->save($user);
        $this->confirmationTokenRepository->delete($confirmationToken);
        return $user;
    }

    public function denyConfirmationToken(ConfirmationToken $confirmationToken)
    {
        $this->confirmationTokenRepository->delete($confirmationToken);
    }

    public function isExpired(ConfirmationToken $confirmationToken)
    {
        $validUntil = Carbon::createFromFormat("Y-m-d H:i:s",$confirmationToken->valid_until);
        return (Carbon::now() <= $validUntil);
    }

    public function createFacebookConfirmationToken(User $user, $facebook_id, $facebook_name, $facebook_access_token, $facebook_access_token_expires_at, $facebook_photo_url)
    {
        $confirmationToken = $this->createConfirmationToken($user,ConfirmationToken::MEDIA_FACEBOOK);
        $facebookIntegration = new FacebookIntegration();
        $facebookIntegration->facebook_id = $facebook_id;
        $facebookIntegration->facebook_name = $facebook_name;
        $facebookIntegration->facebook_access_token = $facebook_access_token;
        $facebookIntegration->facebook_access_token_expires_at = $facebook_access_token_expires_at;
        $facebookIntegration->facebook_photo_url = $facebook_photo_url;
        $facebookIntegration->confirmationToken()->associate($confirmationToken);
        $this->facebookIntegrationRepository->save($facebookIntegration);
        return $confirmationToken;
    }

    public function createTwitterConfirmationToken(User $user, $twitter_id, $twitter_name, $twitter_oauth_token, $twitter_oauth_token_secret, $twitter_photo_url)
    {
        $confirmationToken = $this->createConfirmationToken($user,ConfirmationToken::MEDIA_TWITTER);
        $ti = new TwitterIntegration();
        $ti->twitter_id = $twitter_id;
        $ti->twitter_name = $twitter_name;
        $ti->twitter_oauth_token = $twitter_oauth_token;
        $ti->twitter_oauth_token_secret = $twitter_oauth_token_secret;
        $ti->twitter_photo_url = $twitter_photo_url;
        $ti->confirmationToken()->associate($confirmationToken);
        $this->twitterIntegrationRepository->save($ti);
        return $confirmationToken;
    }
}
<?php

namespace App\Contracts\Services;


use App\Models\ConfirmationToken;
use App\Models\FacebookIntegration;
use App\Models\TwitterIntegration;
use App\Models\User;

interface MailerService
{
    function sendPanelistCredentials($email, $password);

    function notifyChangePassword(User $user);

    function notifyUserHasBeenDeleted(User $user);

    function sendFacebookConfirmationToken(User $user,ConfirmationToken $confirmationToken,FacebookIntegration $facebookIntegration);

    function sendTwitterConfirmationToken(User $user,ConfirmationToken $confirmationToken,TwitterIntegration $twitterIntegration);

    function resetPasswordLink(User $user,$token);
}
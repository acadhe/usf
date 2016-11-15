<?php

namespace App\Contracts\Repositories;


use App\Models\ConfirmationToken;
use App\Models\TwitterIntegration;

interface TwitterIntegrationRepository
{
    /**
     * @param ConfirmationToken $confirmationToken
     * @return TwitterIntegration
     */
    public function findByConfirmationToken(ConfirmationToken $confirmationToken);

    public function save(TwitterIntegration $twitterIntegration);
}
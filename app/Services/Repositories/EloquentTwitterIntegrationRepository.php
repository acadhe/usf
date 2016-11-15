<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\TwitterIntegrationRepository;
use App\Models\ConfirmationToken;
use App\Models\TwitterIntegration;

class EloquentTwitterIntegrationRepository implements TwitterIntegrationRepository
{

    public function findByConfirmationToken(ConfirmationToken $confirmationToken)
    {
        return TwitterIntegration::where('confirmation_token_id','=',$confirmationToken->id)->first();
    }

    public function save(TwitterIntegration $twitterIntegration)
    {
        return $twitterIntegration->save();
    }
}
<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\FacebookIntegrationRepository;
use App\Models\ConfirmationToken;
use App\Models\FacebookIntegration;

class EloquentFacebookIntegrationRepository implements FacebookIntegrationRepository
{

    public function findByConfirmationToken(ConfirmationToken $confirmationToken)
    {
        return FacebookIntegration::where('confirmation_token_id','=',$confirmationToken->id)->first();
    }

    public function save(FacebookIntegration $facebookIntegration)
    {
        return $facebookIntegration->save();
    }
}
<?php

namespace App\Contracts\Repositories;


use App\Models\ConfirmationToken;
use App\Models\FacebookIntegration;

interface FacebookIntegrationRepository
{
    /**
     * @param ConfirmationToken $confirmationToken
     * @return FacebookIntegration
     */
    public function findByConfirmationToken(ConfirmationToken $confirmationToken);

    public function save(FacebookIntegration $facebookIntegration);
}
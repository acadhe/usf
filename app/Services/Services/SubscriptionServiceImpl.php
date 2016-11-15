<?php

namespace App\Services\Services;


use App\Contracts\Repositories\SubscriptionRepository;
use App\Contracts\Services\SubscriptionService;

class SubscriptionServiceImpl implements SubscriptionService
{
    private $subscriptionRepo;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepo = $subscriptionRepository;
    }
}
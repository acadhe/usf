<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\SubscriptionRepository;
use App\Models\Subscription;

class SubscriptionRepositoryImpl implements SubscriptionRepository
{

    public function save(Subscription $subscription)
    {
        return $subscription->save();
    }

    public function delete(Subscription $subscription)
    {
        return $subscription->delete();
    }

}
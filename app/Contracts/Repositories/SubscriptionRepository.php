<?php

namespace App\Contracts\Repositories;


use App\Models\Subscription;

interface SubscriptionRepository
{
    public function save(Subscription $subscription);
    
    public function delete(Subscription $subscription);
}
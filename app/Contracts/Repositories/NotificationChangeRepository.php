<?php

namespace App\Contracts\Repositories;


use App\Models\NotificationChange;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface NotificationChangeRepository
{
    public function updateUnseenToSeen(User $user);

    public function deleteById($id);

    public function save(NotificationChange $notificationChange);

    /**
     * @param Builder $q
     * @return NotificationChange[]
     */
    public function findAllByQuery(Builder $q);
}
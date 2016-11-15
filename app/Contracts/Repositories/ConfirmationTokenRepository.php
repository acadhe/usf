<?php

namespace App\Contracts\Repositories;


use App\Models\ConfirmationToken;

interface ConfirmationTokenRepository
{
    /**
     * @param $id
     * @return ConfirmationToken
     */
    public function findById($id);

    /**
     * @param $token
     * @return ConfirmationToken
     */
    public function findByToken($token);

    public function save(ConfirmationToken $confirmationToken);

    public function delete(ConfirmationToken $confirmationToken);
}
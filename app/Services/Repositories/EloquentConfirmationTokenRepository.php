<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\ConfirmationTokenRepository;
use App\Models\ConfirmationToken;

class EloquentConfirmationTokenRepository implements ConfirmationTokenRepository
{
    public function findByToken($token)
    {
        return ConfirmationToken::where('token','=',$token)->first();
    }

    public function save(ConfirmationToken $confirmationToken)
    {
        return $confirmationToken->save();
    }

    public function delete(ConfirmationToken $confirmationToken)
    {
        return $confirmationToken->delete();
    }

    /**
     * @param $id
     * @return ConfirmationToken
     */
    public function findById($id)
    {
        return ConfirmationToken::where('id','=',$id)->first();
    }
}
<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\ResetPasswordTokenRepository;
use App\Models\ResetPasswordToken;

class EloquentResetPasswordTokenRepository implements ResetPasswordTokenRepository
{

    public function findByToken($token)
    {
        return ResetPasswordToken::where('token','=',$token)->first();
    }

    public function delete(ResetPasswordToken $token)
    {
        return $token->delete();
    }

    public function save(ResetPasswordToken $resetPasswordToken)
    {
        return $resetPasswordToken->save();
    }
}
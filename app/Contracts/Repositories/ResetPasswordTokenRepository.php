<?php

namespace App\Contracts\Repositories;


use App\Models\ResetPasswordToken;

interface ResetPasswordTokenRepository
{
    public function save(ResetPasswordToken $resetPasswordToken);
    /**
     * @param $token
     * @return ResetPasswordToken
     */
    public function findByToken($token);

    public function delete(ResetPasswordToken $resetPasswordToken);
}
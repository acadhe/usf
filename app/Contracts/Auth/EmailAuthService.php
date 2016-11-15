<?php
namespace App\Contracts\Auth;

use App\Exceptions\Auth\EmailUsedException;
use App\Exceptions\Auth\InvalidEmailOrPasswordException;
use App\Models\User;

interface EmailAuthService
{
    /**
     * @param $name
     * @param $email
     * @param $password
     * @return User
     * @throws EmailUsedException
     */
    public function register($name,$email,$password);

    /**
     * @param $email
     * @param $password
     * @return mixed
     * @throws InvalidEmailOrPasswordException
     */
    public function login($email,$password);
}
<?php

namespace App\Services\Auth;


use App\Contracts\Auth\HashPasswordService;

class SHA1HashImpl implements HashPasswordService
{

    public function hash($plain)
    {
        return sha1($plain);
    }

    public function equalsWithHashed($plaintext, $hashedPwd)
    {
        return sha1($plaintext) == $hashedPwd;
    }
}
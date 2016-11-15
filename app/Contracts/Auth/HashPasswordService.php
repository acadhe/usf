<?php

namespace App\Contracts\Auth;


interface HashPasswordService
{
    public function hash($plain);

    public function equalsWithHashed($plaintext,$hashedPwd);

}
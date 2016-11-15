<?php
namespace App\Exceptions\Auth;

use Exception;

class EmailUsedException extends Exception
{
    public function __construct($email){
        parent::__construct($email);
    }
}
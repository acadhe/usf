<?php

namespace App\Exceptions\Images;


use Exception;

class InvalidURLPrefixException extends Exception
{
    public function __construct($message){
        parent::__construct("Invalid prefix in url ".$message);
    }
}
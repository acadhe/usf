<?php

namespace App\Exceptions;



use Exception;

class CannotSeedOnProductionException extends Exception
{
    public function __construct()
    {
        parent::__construct("Cannot seed on production environment! Please use database migration instead, or set APP_ENV to 'local' or 'staging'");
    }
}
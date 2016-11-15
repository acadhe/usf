<?php

namespace App\Exceptions;


class CannotRollbackOnProductionException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Cannot rollback on production environment! Please set APP_ENV to either 'local' or 'staging'");
    }
}
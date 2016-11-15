<?php

namespace App\Contracts\Services;


interface AlertMessageService
{
    public function getSuccess();

    public function setSuccess($message);

    public function getAlert();

    public function setAlert($message);

    public function getError();

    public function setError($message);
}
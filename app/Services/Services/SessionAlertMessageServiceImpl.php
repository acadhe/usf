<?php

namespace App\Services\Services;


use App\Contracts\Services\AlertMessageService;
use Illuminate\Session\Store;

class SessionAlertMessageServiceImpl implements AlertMessageService
{
    const SUCCESS_KEY = "__message_success";
    const ALERT_KEY = "__message_alert";
    const ERROR_KEY = "__message_error";
    private $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function getSuccess()
    {
        return $this->session->get(self::SUCCESS_KEY);
    }

    public function setSuccess($message)
    {
        $this->session->flash(self::SUCCESS_KEY,$message);
    }

    public function getAlert()
    {
        return $this->session->get(self::ALERT_KEY);
    }

    public function setAlert($message)
    {
        $this->session->flash(self::ALERT_KEY,$message);
    }

    public function getError()
    {
        return $this->session->get(self::ERROR_KEY);
    }

    public function setError($message)
    {
        $this->session->flash(self::ERROR_KEY,$message);
    }
}
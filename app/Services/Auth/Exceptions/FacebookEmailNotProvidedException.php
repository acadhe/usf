<?php

namespace App\Services\Auth\Exceptions;


use Exception;

class FacebookEmailNotProvidedException extends Exception
{
    private $fb_id;
    private $name;

    public function __construct($fb_id,$name)
    {
        $this->fb_id = $fb_id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFbId()
    {
        return $this->fb_id;
    }

    /**
     * @return int
     */
    public function getName()
    {
        return $this->name;
    }


}
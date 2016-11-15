<?php

namespace App\Services\Auth\Exceptions;


use Exception;

class TwitterEmailNotProvidedException extends Exception
{
    private $twitter_id;
    private $username;
    private $name;

    public function __construct($twitter_id,$name, $username)
    {
        $this->twitter_id = $twitter_id;
        $this->name = $name;
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getName()
    {
        return $this->name;
    }



}
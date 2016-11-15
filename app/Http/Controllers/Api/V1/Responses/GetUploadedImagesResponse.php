<?php

namespace App\Http\Controllers\Api\V1\Responses;


class GetUploadedImagesResponse
{
    public $status;
    public $message;
    public $urls = [];

    
    public function addUrl($url){
        array_push($this->urls,$url);
    }
    
    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param mixed $urls
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }
    
    
}
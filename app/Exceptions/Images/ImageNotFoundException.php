<?php
namespace App\Exceptions\Images;

use Exception;

class ImageNotFoundException extends Exception
{
    public function __construct($image_name){
        parent::__construct($image_name." not found");
    }
}
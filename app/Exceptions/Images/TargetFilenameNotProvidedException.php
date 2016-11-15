<?php
namespace App\Exceptions\Images;

use Exception;

class TargetFilenameNotProvidedException extends Exception
{
    public function __construct($url)
    {
        parent::__construct("Target filename not provided in url : ".$url);
    }
}
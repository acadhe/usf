<?php

namespace App\Contracts\Services;


interface FeedbackService
{
    public function createFeedback($name,$email,$content);
}
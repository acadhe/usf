<?php

namespace App\Contracts\Repositories;


use App\Models\Feedback;

interface FeedbackRepository
{
    public function save(Feedback $feedback);
}
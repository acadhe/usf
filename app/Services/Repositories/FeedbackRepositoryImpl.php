<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\FeedbackRepository;
use App\Models\Feedback;

class FeedbackRepositoryImpl implements FeedbackRepository
{

    public function save(Feedback $feedback)
    {
        return $feedback->save();
    }
}
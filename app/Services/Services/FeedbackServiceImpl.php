<?php

namespace App\Services\Services;


use App\Contracts\Repositories\FeedbackRepository;
use App\Contracts\Services\FeedbackService;
use App\Models\Feedback;

class FeedbackServiceImpl implements FeedbackService
{
    private $feedbackRepo;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepo = $feedbackRepository;
    }

    public function createFeedback($name, $email, $content)
    {
        $feedback = new Feedback();
        $feedback->name = $name;
        $feedback->email = $email;
        $feedback->content = $content;
        $this->feedbackRepo->save($feedback);
    }
}
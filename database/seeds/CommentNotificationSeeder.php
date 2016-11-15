<?php

use App\Contracts\Services\NotificationService;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentNotificationSeeder extends Seeder
{
    private $notificationService;
    
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;    
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    }
}
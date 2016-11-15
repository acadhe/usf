<?php

namespace App\Providers;


use App\Contracts\Services\AlertMessageService;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\BookmarkService;
use App\Contracts\Services\CommentService;
use App\Contracts\Services\ConfirmationTokenService;
use App\Contracts\Services\FeedbackService;
use App\Contracts\Services\ImageUploadService;
use App\Contracts\Services\MailerService;
use App\Contracts\Services\NotificationService;
use App\Contracts\Services\ShareCounterService;
use App\Contracts\Services\SocialMediaService;
use App\Contracts\Services\SubscriptionService;
use App\Contracts\Services\UserService;
use App\Contracts\Services\UserVoteArticleService;
use App\Services\Services\ArticleServiceImpl;
use App\Services\Services\BookmarkServiceImpl;
use App\Services\Services\CloudinaryImageUploadImpl;
use App\Services\Services\CommentServiceImpl;
use App\Services\Services\ConfirmationTokenServiceImpl;
use App\Services\Services\FeedbackServiceImpl;
use App\Services\Services\ImageUploadServiceImpl;
use App\Services\Services\MailgunMailerService;
use App\Services\Services\NotificationServiceImpl;
use App\Services\Services\SessionAlertMessageServiceImpl;
use App\Services\Services\ShareCounterServiceImpl;
use App\Services\Services\SocialMediaServiceImpl;
use App\Services\Services\SubscriptionServiceImpl;
use App\Services\Services\UserServiceImpl;
use App\Services\Services\UserVoteArticleServiceImpl;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationService::class,NotificationServiceImpl::class);
        $this->app->bind(MailerService::class,MailgunMailerService::class);
        $this->app->bind(ConfirmationTokenService::class,ConfirmationTokenServiceImpl::class);
        $this->app->bind(ArticleService::class,ArticleServiceImpl::class);
        $this->app->bind(BookmarkService::class,BookmarkServiceImpl::class);
        $this->app->bind(CommentService::class,CommentServiceImpl::class);
        $this->app->bind(UserService::class,UserServiceImpl::class);
        $this->app->bind(AlertMessageService::class,SessionAlertMessageServiceImpl::class);
        $this->app->bind(FeedbackService::class,FeedbackServiceImpl::class);
        $this->app->bind(SocialMediaService::class,SocialMediaServiceImpl::class);
        $this->app->bind(ShareCounterService::class,ShareCounterServiceImpl::class);
        $this->app->bind(SubscriptionService::class,SubscriptionServiceImpl::class);
        $this->app->bind(ImageUploadService::class,CloudinaryImageUploadImpl::class);
        $this->app->bind(UserVoteArticleService::class,UserVoteArticleServiceImpl::class);
    }
}
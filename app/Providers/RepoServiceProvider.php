<?php

namespace App\Providers;


use App\Contracts\Repositories\ArticleCategoryRepository;
use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\BookmarkRepository;
use App\Contracts\Repositories\CommentRepository;
use App\Contracts\Repositories\ConfirmationTokenRepository;
use App\Contracts\Repositories\FacebookIntegrationRepository;
use App\Contracts\Repositories\FeedbackRepository;
use App\Contracts\Repositories\NotificationChangeRepository;
use App\Contracts\Repositories\NotificationObjectRepository;
use App\Contracts\Repositories\NotificationRepository;
use App\Contracts\Repositories\ResetPasswordTokenRepository;
use App\Contracts\Repositories\SubscriptionRepository;
use App\Contracts\Repositories\TwitterIntegrationRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\UserVoteArticleRepository;
use App\Contracts\Repositories\UserVoteCommentRepository;
use App\Services\Repositories\ArticleCategoryRepositoryImpl;
use App\Services\Repositories\ArticleRepositoryImpl;
use App\Services\Repositories\BookmarkRepositoryImpl;
use App\Services\Repositories\CommentRepositoryImpl;
use App\Services\Repositories\EloquentConfirmationTokenRepository;
use App\Services\Repositories\EloquentFacebookIntegrationRepository;
use App\Services\Repositories\EloquentResetPasswordTokenRepository;
use App\Services\Repositories\EloquentTwitterIntegrationRepository;
use App\Services\Repositories\FeedbackRepositoryImpl;
use App\Services\Repositories\NotificationChangeRepositoryImpl;
use App\Services\Repositories\NotificationObjectRepositoryImpl;
use App\Services\Repositories\NotificationRepositoryImpl;
use App\Services\Repositories\SubscriptionRepositoryImpl;
use App\Services\Repositories\UserRepositoryImpl;
use App\Services\Repositories\UserVoteArticleRepositoryImpl;
use App\Services\Repositories\UserVoteCommentRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FacebookIntegrationRepository::class,EloquentFacebookIntegrationRepository::class);
        $this->app->bind(TwitterIntegrationRepository::class,EloquentTwitterIntegrationRepository::class);
        $this->app->bind(ConfirmationTokenRepository::class,EloquentConfirmationTokenRepository::class);
        $this->app->bind(ResetPasswordTokenRepository::class,EloquentResetPasswordTokenRepository::class);
        $this->app->bind(ArticleCategoryRepository::class,ArticleCategoryRepositoryImpl::class);
        $this->app->bind(UserRepository::class,UserRepositoryImpl::class);
        $this->app->bind(ArticleRepository::class,ArticleRepositoryImpl::class);
        $this->app->bind(BookmarkRepository::class,BookmarkRepositoryImpl::class);
        $this->app->bind(CommentRepository::class,CommentRepositoryImpl::class);
        $this->app->bind(UserVoteCommentRepository::class,UserVoteCommentRepositoryImpl::class);
        $this->app->bind(FeedbackRepository::class,FeedbackRepositoryImpl::class);
        $this->app->bind(NotificationRepository::class,NotificationRepositoryImpl::class);
        $this->app->bind(NotificationObjectRepository::class,NotificationObjectRepositoryImpl::class);
        $this->app->bind(NotificationChangeRepository::class,NotificationChangeRepositoryImpl::class);
        $this->app->bind(SubscriptionRepository::class,SubscriptionRepositoryImpl::class);
        $this->app->bind(UserVoteArticleRepository::class,UserVoteArticleRepositoryImpl::class);
    }
}
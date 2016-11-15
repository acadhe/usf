<?php

namespace App\Providers;

use App\Contracts\Auth\EmailAuthService;
use App\Contracts\Auth\FacebookAuthService;
use App\Contracts\Auth\GooglePlusAuthService;
use App\Contracts\Auth\HashPasswordService;
use App\Contracts\Auth\TwitterAuthService;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use App\Services\Auth\EmailAuthServiceImpl;
use App\Services\Auth\FacebookAuthServiceImpl;
use App\Services\Auth\GooglePlusAuthServiceImpl;
use App\Services\Auth\SHA1HashImpl;
use App\Services\Auth\TwitterAuthServiceImpl;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
        Comment::class => CommentPolicy::class,
        Article::class => ArticlePolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }

    public function register()
    {
        $this->app->bind(HashPasswordService::class,SHA1HashImpl::class);
        $this->app->bind(EmailAuthService::class,EmailAuthServiceImpl::class);
        $this->app->bind(TwitterAuthService::class,TwitterAuthServiceImpl::class);
        $this->app->bind(FacebookAuthService::class,FacebookAuthServiceImpl::class);
        $this->app->bind(GooglePlusAuthService::class,GooglePlusAuthServiceImpl::class);
    }
}

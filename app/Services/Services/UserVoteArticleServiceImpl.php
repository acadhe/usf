<?php

namespace App\Services\Services;


use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\UserVoteArticleRepository;
use App\Contracts\Services\UserVoteArticleService;
use App\Models\Article;
use App\Models\User;
use App\Models\UserVoteArticle;

class UserVoteArticleServiceImpl implements UserVoteArticleService
{
    private $userVoteArticleRepository;
    private $articleRepository;
    public function __construct(UserVoteArticleRepository $userVoteArticleRepository,ArticleRepository $articleRepository)
    {
        $this->userVoteArticleRepository = $userVoteArticleRepository;
        $this->articleRepository = $articleRepository;
    }

    public function vote(User $user, Article $article)
    {
        $userVoteArticle = $this->userVoteArticleRepository->findOneByUserAndArticle($user,$article);
        if ($userVoteArticle == null){
            $userVoteArticle = new UserVoteArticle();
            $userVoteArticle->user()->associate($user);
            $userVoteArticle->article()->associate($article);
            $this->userVoteArticleRepository->save($userVoteArticle);

            $this->recountNumberOfVotesAndSave($article);
        }
    }

    public function unvote(User $user, Article $article)
    {
        $userVoteArticle = $this->userVoteArticleRepository->findOneByUserAndArticle($user,$article);
        if ($userVoteArticle != null){
            $this->userVoteArticleRepository->delete($userVoteArticle);

            $this->recountNumberOfVotesAndSave($article);
        }
    }

    private function recountNumberOfVotesAndSave(Article $article){
        $article->votes_count = $this->userVoteArticleRepository->countArticleVote($article);
        $this->articleRepository->save($article);
    }
}
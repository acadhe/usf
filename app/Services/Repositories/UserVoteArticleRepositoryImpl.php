<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\UserVoteArticleRepository;
use App\Models\Article;
use App\Models\User;
use App\Models\UserVoteArticle;

class UserVoteArticleRepositoryImpl implements UserVoteArticleRepository
{

    public function save(UserVoteArticle $userVoteArticle)
    {
        return $userVoteArticle->save();
    }

    public function findOneByUserAndArticle(User $user, Article $article)
    {
        $userVoteArticle = UserVoteArticle::where('user_id','=',$user->id)
            ->where('article_id','=',$article->id)->first();
        return $userVoteArticle;
    }

    public function delete(UserVoteArticle $userVoteArticle)
    {
        return $userVoteArticle->delete();
    }

    /**
     * Determine if user votes an article
     * @param User $user
     * @param Article $article
     * @return boolean
     */
    public function isVote(User $user, Article $article)
    {
        return ($this->findOneByUserAndArticle($user,$article) != null);
    }

    public function countArticleVote(Article $article)
    {
        return UserVoteArticle::where('article_id','=',$article->id)->count();
    }


}
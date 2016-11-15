<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\ArticleRepository;
use App\Models\Article;
use App\Models\User;
use App\Models\UserVoteArticle;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ArticleRepositoryImpl implements ArticleRepository
{
    private $db;

    public function __construct(Connection $database)
    {
        $this->db = $database;
    }

    public function save(Article $article)
    {
        return $article->save();
    }

    public function delete(Article $article)
    {
        return $article->delete();
    }

    public function findAllByUser(User $user)
    {
        return Article::where('user_id','=',$user->id)->get();
    }

    /**
     * @param $id
     * @return Article
     */
    public function findById($id)
    {
        return Article::where('id','=',$id)->first();
    }

    public function findAllByBookmarked(User $user)
    {
        return $user->bookmarkedArticles()->get();
    }

    public function findAllVotedByUser(User $user)
    {
        $articles = new Collection();
        $userVoteArticles = UserVoteArticle::where('user_id','=',$user->id)->with(['article'])->get();
        foreach ($userVoteArticles as $userVoteArticle){
            $articles->push($userVoteArticle->article);
        }
        return $articles;
    }

    public function findAllByQuery(Builder $q)
    {
        return $q->get();
    }

    public function findAll()
    {
        return Article::all();
    }

    public function findAllByUserAndPrivacy(User $user, $privacy)
    {
        return $user->articles()->where('privacy','=',$privacy)->get();
    }
}
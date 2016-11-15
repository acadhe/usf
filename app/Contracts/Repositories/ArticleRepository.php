<?php

namespace App\Contracts\Repositories;


use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface ArticleRepository
{
    /**
     * @param $id
     * @return Article
     */
    public function findById($id);

    /**
     * @param User $user
     * @return Article[]
     */
    public function findAllByUser(User $user);

    /**
     * @param User $user
     * @param $privacy
     * @return Article[]
     */
    public function findAllByUserAndPrivacy(User $user, $privacy);

    public function findAllVotedByUser(User $user);

    public function delete(Article $article);

    public function save(Article $article);
    
    public function findAllByBookmarked(User $user);

    public function findAllByQuery(Builder $q);

    public function findAll();
}
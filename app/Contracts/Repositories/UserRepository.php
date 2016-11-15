<?php

namespace App\Contracts\Repositories;

use App\Models\Article;
use App\Models\User;

interface UserRepository
{
    /**
     * @param $id
     * @return User
     */
    public function findById($id);

    public function delete(User $user);
    
    public function save(User $user);

    public function findByFacebookId($id);

    public function findByTwitterId($twitter_id);

    public function findByGooglePlusId($gplusid);

    public function findByEmail($email);

    public function findAllByNotType($type);

    public function findAllByType($type);

    public function findAllByArticleSubscriber(Article $article);

    public function findAllByArticleBookmarker(Article $article);

    public function findAllByNameLikeAndType($name, $type);

    public function findAll();

    public function findAllByNameLike($input);

}
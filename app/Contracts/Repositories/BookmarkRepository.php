<?php

namespace App\Contracts\Repositories;


use App\Models\Article;
use App\Models\Bookmark;

interface BookmarkRepository
{
    public function save(Bookmark $bookmark);

    public function delete(Bookmark $bookmark);

    /**
     * Count how many user bookmark this article
     * @param Article $article
     * @return integer
     */
    public function countArticleBookmarks(Article $article);


    public function findByArticleAndUser($article, $user);
}
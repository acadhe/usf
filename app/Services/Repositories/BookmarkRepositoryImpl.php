<?php

namespace App\Services\Repositories;


use App\Contracts\Repositories\BookmarkRepository;
use App\Models\Article;
use App\Models\Bookmark;

class BookmarkRepositoryImpl implements BookmarkRepository
{

    public function save(Bookmark $bookmark)
    {
        $bookmark->save();
    }

    public function delete(Bookmark $bookmark)
    {
        $bookmark->delete();
    }

    /**
     * Count how many user bookmark this article
     * @param Article $article
     * @return integer
     */
    public function countArticleBookmarks(Article $article)
    {
        return $article->bookmarks()->count();
    }

    public function findByArticleAndUser($article, $user)
    {
        return Bookmark::where('article_id','=',$article->id)->where('user_id','=',$user->id)->first();
    }
}
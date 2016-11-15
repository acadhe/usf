<?php

namespace App\Services\Services;
use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\BookmarkRepository;
use App\Contracts\Services\BookmarkService;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\User;

class BookmarkServiceImpl implements BookmarkService
{
    private $bookmarkRepo;
    private $articleRepo;

    public function __construct(BookmarkRepository $bookmarkRepo,ArticleRepository $articleRepository)
    {
        $this->bookmarkRepo = $bookmarkRepo;
        $this->articleRepo = $articleRepository;
    }

    public function markArticle(Article $article,User  $user)
    {
        $bookmark = $this->bookmarkRepo->findByArticleAndUser($article,$user);
        if ($bookmark === null){
            $bookmark = new Bookmark();
            $bookmark->article_id = $article->id;
            $bookmark->user_id = $user->id;
            $this->bookmarkRepo->save($bookmark);
            $this->updateArticleBookmarksCount($article);
        }
    }

    public function unmarkArticle(Article $article,User $user)
    {
        $bookmark = $this->bookmarkRepo->findByArticleAndUser($article,$user);
        if ($bookmark !== null){
            $this->bookmarkRepo->delete($bookmark);
            $this->updateArticleBookmarksCount($article);
        }
    }

    public function isArticleBookmarked(Article $article,User $user)
    {
        return $this->bookmarkRepo->findByArticleAndUser($article,$user) != null;
    }

    private function updateArticleBookmarksCount(Article $article){
        $article->bookmarks_count = $this->bookmarkRepo->countArticleBookmarks($article);
        $this->articleRepo->save($article);
    }
}
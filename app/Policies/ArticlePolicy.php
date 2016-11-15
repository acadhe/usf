<?php

namespace App\Policies;

use App\Contracts\Repositories\UserVoteArticleRepository;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\BookmarkService;
use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    private $bookmarkService;
    private $userVoteArticleRepository;

    /**
     * Create a new policy instance.
     *
     * @param BookmarkService $bookmarkService
     * @param UserVoteArticleRepository $userVoteArticleRepository
     */
    public function __construct(BookmarkService $bookmarkService,UserVoteArticleRepository $userVoteArticleRepository)
    {
        $this->bookmarkService = $bookmarkService;
        $this->userVoteArticleRepository = $userVoteArticleRepository;
    }

    public function create(User $user,Article $article)
    {
        return $user->isAdmin() || $user->isPanelist();
    }

    public function update(User $user,Article $article)
    {
        return ($user->id == $article->user_id) && ($article->open);
    }

    public function mark(User $user,Article $article)
    {   
        return !$this->bookmarkService->isArticleBookmarked($article, $user);
    }
    
    public function unmark(User $user,Article $article)
    {
        return $this->bookmarkService->isArticleBookmarked($article, $user);
    }

    public function open(User $user,Article $article)
    {
        return ($article->user_id == $user->id) && (!$article->open);
    }

    public function close(User $user,Article $article)
    {
        return ($article->user_id == $user->id) && ($article->open);
    }

    public function comment(User $user,Article $article)
    {
        return $article->open;
    }

    public function delete(User $user,Article $article)
    {
        return ($user->id == $article->user_id);
    }

    public function vote(User $user,Article $article)
    {
        //can vote == user hasn't vote the article yet
        return !$this->userVoteArticleRepository->isVote($user,$article);
    }

    public function unvote(User $user,Article $article){
        return $this->userVoteArticleRepository->isVote($user,$article);
    }

    public function updateSummary(User $user,Article $article){
        return ($user->id == $article->user_id);
    }

    public function deleteSummary(User $user,Article $article){
        return ($user->id == $article->user_id);
    }

    public function changePrivacy(User $user,Article $article){
        return ($user->id == $article->user_id);
    }
}

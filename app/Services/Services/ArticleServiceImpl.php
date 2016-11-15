<?php

namespace App\Services\Services;
use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\BookmarkRepository;
use App\Contracts\Repositories\CommentRepository;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\ImageUploadService;
use App\Contracts\Services\NotificationService;
use App\Contracts\Services\ShareCounterService;
use App\Contracts\Services\SubscriptionService;
use App\Http\Requests\Articles\CreateArticleRequest;
use App\Http\Requests\Articles\UpdateArticleRequest;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ArticleServiceImpl implements ArticleService
{
    private $articleRepo;
    private $shareCounterService;
    private $commentRepo;
    private $bookmarkRepo;
    private $subscriptionService;
    private $imageUploadService;
    private $notificationService;

    public function __construct(NotificationService $notificationService,ArticleRepository $articleRepo,BookmarkRepository $bookmarkRepo,
                                ShareCounterService $shareCounterService,CommentRepository $commentRepo,
                                SubscriptionService $subscriptionService,ImageUploadService $imageUploadService)
    {
        $this->notificationService = $notificationService;
        $this->articleRepo = $articleRepo;
        $this->shareCounterService = $shareCounterService;
        $this->commentRepo = $commentRepo;
        $this->bookmarkRepo = $bookmarkRepo;
        $this->subscriptionService = $subscriptionService;
        $this->imageUploadService = $imageUploadService;
    }

    public function updateShareCount(Article $article)
    {
        $a = $this->shareCounterService->getArticleShareCountOfFacebook($article);
        $b = $this->shareCounterService->getArticleShareCountOfTwitter($article);
        $sum = $a + $b;
        $article->shares_count = $sum;
        $this->articleRepo->save($article);
        return $sum;
    }

    public function updateArticle(Article $article, UpdateArticleRequest $request){
        $article->privacy = $request->input('privacy');
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->category = $request->input('category');
        if ($request->hasFile('headerimg')){
            $file = $request->file('headerimg');
            $article->header_image_url = $this->imageUploadService->storeUpdateArticleImage($article,$file);
        }
        return $this->articleRepo->save($article);
    }

    public function createArticleFromRequest(CreateArticleRequest $request,User $creator)
    {
        $article = new Article();
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->category = $request->input('category');
        $article->privacy = $request->input('privacy',Article::PRIVACY_DRAFT);
        $article->user_id = $creator->id;
        $this->articleRepo->save($article);
        return $article->id;
    }

    public function closeArticle(Article $article, User $actor, $summary)
    {
        $article->open = false;
        $article->summary = $summary;
        $this->notificationService->addPanelistCloseArticle($actor, $article);
        return $this->articleRepo->save($article);
    }

    public function publishArticle(Article $article)
    {
        $article->privacy = Article::PRIVACY_PUBLISHED;
        return $this->articleRepo->save($article);
    }

    public function createBlankArticle(User $user)
    {
        $article = new Article();
        $article->title = '';
        $article->category = '';
        $article->user()->associate($user);
        $this->articleRepo->save($article);
        return $article;
    }

}
<?php

use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Services\ArticleService;
use App\Contracts\Services\NotificationService;
use App\Models\User;
use Illuminate\Database\Seeder;

class PanelistCloseArticleSeeder extends Seeder
{
    private $articleService;
    private $notificationService;
    private $articleRepository;
    
    public function __construct(ArticleRepository $articleRepository,ArticleService $articleService,NotificationService $notificationService)
    {
        $this->articleRepository = $articleRepository;
        $this->articleService = $articleService;
        $this->notificationService = $notificationService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $article = $this->articleRepository->findById(3);
        $this->articleService->closeArticle($article,$article->user, "The summary is woow");

    }
}
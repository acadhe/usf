<?php

use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\BookmarkService;
use App\Models\Article;
use App\Models\Bookmark;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookmarkSeeder extends Seeder
{
    private $bookmarkService;
    private $userRepository;
    private $articleRepository;

    public function __construct(BookmarkService $bookmarkService,ArticleRepository $articleRepository,UserRepository $userRepository)
    {
        $this->bookmarkService = $bookmarkService;
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('database.default') == 'pgsql'){
            DB::statement("SELECT setval('bookmarks_id_seq',1,FALSE)");
        }
        $users = $this->userRepository->findAll();
        //find article 3 or 4
        $query = Article::query()->orWhere('id','=',3)->orWhere('id','=',4);
        $articles = $this->articleRepository->findAllByQuery($query);
        //bookmark article 3 and 4
        foreach($users as $user){
            foreach($articles as $article){
                $this->bookmarkService->markArticle($article,$user);
            }
        }
    }
}
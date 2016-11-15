<?php

use App\Contracts\Repositories\ArticleRepository;
use App\Contracts\Repositories\CommentRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Services\CommentService;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentTableSeeder extends Seeder
{
    private $commentService;
    private $userRepository;
    private $articleRepository;
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository,CommentService $commentService,UserRepository $userRepository,ArticleRepository $articleRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->commentService = $commentService;
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('database.default') == 'pgsql') {
            DB::statement("SELECT setval('comments_id_seq',1,FALSE)");
        }
        $faker = Faker\Factory::create();
        $users = $this->userRepository->findAll();
        $articles = $this->articleRepository->findAll();
        foreach ($articles as $article) {
            //each user comment on article
            foreach ($users as $user) {
                if ($article->user->id != $user->id) {
                    if ($user->id % 2 == 0) {
                        $support = Comment::SUPPORT_PRO;
                    } else {
                        $support = Comment::SUPPORT_CONTRA;
                    }
                    $this->commentService->postComment($article, $user, $faker->sentence, $support, null);
                }
            }
        }
        //reply each comments
        $comments = $this->commentRepository->findAll();
        foreach($comments as $comment){
            foreach($users as $user){
                if ($comment->user->id != $user->id){
                    $this->commentService->postComment($comment->article,$user,$faker->sentence,Comment::SUPPORT_REPLY_COMMENT,$comment);
                }
            }
        }
    }
}

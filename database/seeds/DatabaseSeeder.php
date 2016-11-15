<?php

use App\Exceptions\CannotSeedOnProductionException;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws CannotSeedOnProductionException
     */
    public function run()
    {
        if (!in_array(env('APP_ENV'),['local','staging'])){
            throw new CannotSeedOnProductionException();
        }
        $this->call(CleanerSeeder::class);
        $this->call(ArticleCategorySeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ArticleTableSeeder::class);
        $this->call(BookmarkSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(SubscriptionTableSeeder::class);
        $this->call(CommentNotificationSeeder::class);
        $this->call(PanelistCloseArticleSeeder::class);
    }
}

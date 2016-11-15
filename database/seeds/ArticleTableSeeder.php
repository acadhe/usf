<?php

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table("articles")->insert([
            ["id"=>1,"title"=>"artikel ".$faker->sentence,"content"=>$faker->text(1000),"user_id"=>"2","created_at"=>Carbon::now(),"updated_at"=>Carbon::now(),"comments_count"=>5,"shares_count"=>0,"category"=>"Technology and Innovation in Urban Development","privacy"=>Article::PRIVACY_PUBLISHED],
            ["id"=>2,"title"=>"artikel ".$faker->sentence,"content"=>$faker->text(1000),"user_id"=>"2","created_at"=>Carbon::now(),"updated_at"=>Carbon::now(),"comments_count"=>5,"shares_count"=>0,"category"=>"Technology and Innovation in Urban Development","privacy"=>Article::PRIVACY_PUBLISHED],
            ["id"=>3,"title"=>"artikel ".$faker->sentence,"content"=>$faker->text(1000),"user_id"=>"4","created_at"=>Carbon::now(),"updated_at"=>Carbon::now(),"comments_count"=>5,"shares_count"=>0,"category"=>"Urban Green Space","privacy"=>Article::PRIVACY_PUBLISHED],
            ["id"=>4,"title"=>"artikel ".$faker->sentence,"content"=>$faker->text(1000),"user_id"=>"4","created_at"=>Carbon::now(),"updated_at"=>Carbon::now(),"comments_count"=>5,"shares_count"=>0,"category"=>"Urban Green Space","privacy"=>Article::PRIVACY_PUBLISHED],
        ]);
        if (config('database.default') == 'pgsql'){
            $count = Article::count(); $count++;
            DB::statement("SELECT setval('articles_id_seq',$count,FALSE)");
        }
    }
}

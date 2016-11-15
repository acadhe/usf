<?php

use App\Exceptions\CannotRollbackOnProductionException;
use App\Models\ArticleCategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoriesTable extends Migration
{
    private $tablename = "article_categories";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function(Blueprint $table){
            $table->bigIncrements("id");
            $table->string("name");
            $table->unique("name");
        });

        DB::table('article_categories')->insert([
            ["id" => 1, "name" => "Technology and Innovation in Urban Development"],
            ["id" => 2, "name" => "Urban Green Space"],
            ["id" => 3, "name" => "Transportation"],
            ["id" => 4, "name" => "Non-motorized transportation"],
            ["id" => 5, "name" => "Creative Economic Development"],
            ["id" => 6, "name" => "Participatory Budgeting"],
            ["id" => 7, "name" => "Climate Change Resilience"],
            ["id" => 8, "name" => "Trash Management"],
            ["id" => 9, "name" => "Housing Problem"],
            ["id" => 10, "name" => "Riverbank Settlement"],
            ["id" => 11, "name" => "Urban Heritage"],
            ["id" => 12, "name" => "Cultural Identities"],
            ["id" => 13, "name" => "Social Inclusion and Poverty Reduction"],
            ["id" => 14, "name" => "Youth Movement"],
            ["id" => 15, "name" => "Children Right"]
        ]);
        
        if (config('database.default') == 'pgsql'){
            $count = ArticleCategory::count(); $count++;
            DB::statement("SELECT setval('article_categories_id_seq',$count,FALSE)");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @throws CannotRollbackOnProductionException
     */
    public function down()
    {
        if (!in_array(env('APP_ENV'),['local','staging']))
            throw new CannotRollbackOnProductionException();
        Schema::drop($this->tablename);
    }
}

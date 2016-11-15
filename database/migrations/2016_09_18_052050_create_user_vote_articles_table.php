<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUserVoteArticlesTable extends Migration
{
    private $tablename = "user_vote_articles";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function (Blueprint $t){
            $t->bigIncrements('id');
            $t->bigInteger('user_id')->unsigned();
            $t->bigInteger('article_id')->unsigned();
            $t->unique(['user_id','article_id']);

            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $t->foreign('article_id')->references('id')->on('articles')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table("articles",function(Blueprint $t){
            $t->bigInteger('votes_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tablename,function(Blueprint $t){
            $t->dropForeign($this->tablename."_user_id_foreign");
            $t->dropForeign($this->tablename."_article_id_foreign");
        });
        Schema::table('articles',function(Blueprint $t){
            $t->dropColumn('votes_count')->default(0);
        });
        Schema::drop($this->tablename);
    }
}

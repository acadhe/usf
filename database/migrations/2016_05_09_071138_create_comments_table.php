<?php

use App\Exceptions\CannotRollbackOnProductionException;
use App\Models\Comment;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    private $tablename = 'comments';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('article_id')->unsigned();
            $table->bigInteger('replied_comment_id')->unsigned()->nullable();
            $table->text('content');
            $table->enum('support',[Comment::SUPPORT_PRO,Comment::SUPPORT_CONTRA,Comment::SUPPORT_REPLY_COMMENT]);
            $table->boolean('show')->default(true);
            $table->bigInteger('votes_count')->default(0);
            $table->timestamps();
            $table->index('support');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('replied_comment_id')->references('id')->on('comments')->onDelete('cascade')->onUpdate('cascade');
        });
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
        Schema::table($this->tablename,function(Blueprint $table){
            $table->dropForeign($this->tablename."_replied_comment_id_foreign");
            $table->dropForeign($this->tablename."_user_id_foreign");
            $table->dropForeign($this->tablename."_article_id_foreign");
        });
        Schema::drop($this->tablename);

    }
}

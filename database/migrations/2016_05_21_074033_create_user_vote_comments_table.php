<?php

use App\Exceptions\CannotRollbackOnProductionException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUserVoteCommentsTable extends Migration
{
    private $tablename = "user_vote_comments";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function(Blueprint $table){
            $table->bigIncrements("id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("comment_id");
            $table->unique(["user_id","comment_id"]);

            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade')->onUpdate('cascade');
            $table->foreign("comment_id")->references("id")->on('comments')->onDelete('cascade')->onUpdate('cascade');

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
            $table->dropForeign($this->tablename."_user_id_foreign");
            $table->dropForeign($this->tablename."_comment_id_foreign");
        });
        Schema::drop($this->tablename);
    }
}

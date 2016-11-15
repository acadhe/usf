<?php

use App\Exceptions\CannotRollbackOnProductionException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    private $tablename = 'articles';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
            $table->unsignedInteger('comments_count')->default(0);
            $table->unsignedInteger('shares_count')->default(0);
            $table->boolean('open')->default(true);
            $table->string('privacy')->default('draft');
            $table->string('category');

            $table->index('category');
            $table->index('created_at');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        });
        Schema::drop($this->tablename);
    }
}

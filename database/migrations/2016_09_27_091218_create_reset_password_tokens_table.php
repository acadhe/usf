<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateResetPasswordTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reset_password_tokens',function(Blueprint $t){
            $t->bigIncrements('id')->unsigned();;
            $t->bigInteger('user_id')->unsigned();;
            $t->string('token');
            $t->dateTime('valid_until');
            $t->unique('token');
            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reset_password_tokens',function(Blueprint $t){
            $t->dropForeign('reset_password_tokens_user_id_foreign');
        });
        Schema::drop('reset_password_tokens');
    }
}

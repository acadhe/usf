<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateConfirmationTokensTableAndConfirmedAttributeForEachLogInAttemptInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmation_tokens',function(Blueprint $t){
            $t->bigIncrements('id');
            $t->string('token')->unique();
            $t->enum('media',['basic','facebook','twitter','google_plus']);
            $t->bigInteger('user_id')->unsigned();
            $t->dateTime('valid_until');

            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $t->index('user_id');
            $t->index('valid_until');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confirmation_tokens',function(Blueprint $t){
            $t->dropForeign('confirmation_tokens_user_id_foreign');
        });
        Schema::drop('confirmation_tokens');
    }
}

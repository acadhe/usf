<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTwitterIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitter_integrations',function(Blueprint $t){
            $t->bigIncrements('id');
            $t->string('twitter_id');
            $t->string('twitter_name');
            $t->string('twitter_oauth_token');
            $t->string('twitter_oauth_token_secret');
            $t->string('twitter_photo_url')->nullable();

            $t->bigInteger('confirmation_token_id')->unsigned()->unique();
            $t->foreign('confirmation_token_id')->references('id')->on('confirmation_tokens')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('twitter_integrations',function(Blueprint $t){
            $t->dropForeign('twitter_integrations_confirmation_token_id_foreign');
        });
        Schema::drop('twitter_integrations');
    }
}

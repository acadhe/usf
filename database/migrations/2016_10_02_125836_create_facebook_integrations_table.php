<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFacebookIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_integrations',function(Blueprint $t){
            $t->bigIncrements('id');
            $t->bigInteger('confirmation_token_id')->unsigned()->unique();
            $t->foreign('confirmation_token_id')->references('id')->on('confirmation_tokens')->onDelete('cascade')->onUpdate('cascade');

            $t->string('facebook_id');
            $t->string('facebook_name');
            $t->string('facebook_access_token');
            $t->string('facebook_access_token_expires_at');
            $t->string('facebook_photo_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facebook_integrations',function(Blueprint $t){
            $t->dropForeign('facebook_integrations_confirmation_token_id_foreign');
        });
        Schema::drop('facebook_integrations');
    }
}

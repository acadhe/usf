<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddSocmedAccessTokensToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function (Blueprint $t){
            $t->string('facebook_access_token')->nullable();
            $t->dateTime('facebook_access_token_expires_at')->nullable();
            $t->string('twitter_oauth_token')->nullable();
            $t->string('twitter_oauth_token_secret')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function(Blueprint $t){
            $t->dropColumn('facebook_access_token');
            $t->dropColumn('facebook_access_token_expires_at');
            $t->dropColumn('twitter_oauth_token');
            $t->dropColumn('twitter_oauth_token_secret');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddSocmedNameToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function(Blueprint $t){
            $t->string('facebook_name')->nullable();
            $t->string('twitter_name')->nullable();
            $t->string('google_plus_name')->nullable();
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
            $t->dropColumn('facebook_name');
            $t->dropColumn('twitter_name');
            $t->dropColumn('google_plus_name');
        });
    }
}

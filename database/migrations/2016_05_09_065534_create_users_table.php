<?php

use App\Exceptions\CannotRollbackOnProductionException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    private $tablename = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('description')->nullable();
            $table->string('email')->unique();
            //nullable since can login via facebook twitter etc.
            $table->string('password')->nullable();
            //either panelists, user, or admin...
            $table->string('type');
            $table->rememberToken();
            $table->string('facebook_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('google_plus_id')->nullable();
            $table->string('photo_url')->nullable();
            $table->index('facebook_id');
            $table->index('twitter_id');
            $table->index('google_plus_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @throws Exception
     */
    public function down()
    {
        if (!in_array(env('APP_ENV'),['local','staging']))
            throw new CannotRollbackOnProductionException();
        Schema::drop($this->tablename);

    }
}

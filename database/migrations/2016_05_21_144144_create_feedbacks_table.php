<?php

use App\Exceptions\CannotRollbackOnProductionException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    private $tablename = "feedbacks";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function(Blueprint $table){
            $table->bigIncrements("id");
            $table->string('name');
            $table->string("email");
            $table->text('content');
            $table->timestamps();
            $table->boolean('seen')->default(false);
            $table->index('created_at');
            $table->index('seen');
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
        Schema::drop($this->tablename);
    }
}

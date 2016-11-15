<?php

use App\Exceptions\CannotRollbackOnProductionException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateNotificationChangesTable extends Migration
{
    private $tablename = "notification_changes";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function(Blueprint $table){
            $table->bigIncrements("id");
            $table->unsignedBigInteger("notification_object_id");
            $table->string('action');
            $table->unsignedBigInteger("actor_id");
            $table->timestamps();
            $table->string('adverb')->nullable();
            $table->string('entity_type')->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->boolean('seen')->default(false);

            $table->index('created_at');
            $table->index('seen');
            $table->foreign("actor_id")->references("id")->on("users")->onDelete('cascade')->onUpdate('cascade');
            $table->foreign("notification_object_id")->references("id")->on("notification_objects")
                ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table($this->tablename,function (Blueprint $table){
            $table->dropForeign($this->tablename."_actor_id_foreign");
            $table->dropForeign($this->tablename."_notification_object_id_foreign");
        });
        Schema::drop($this->tablename);
    }
}

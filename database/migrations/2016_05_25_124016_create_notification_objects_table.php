<?php

use App\Exceptions\CannotRollbackOnProductionException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateNotificationObjectsTable extends Migration
{
    private $tablename = "notification_objects";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename,function(Blueprint $table){
            $table->bigIncrements("id");
            $table->unsignedBigInteger('notification_id');
            $table->unsignedBigInteger("object_id");
            $table->string('object_type');
            $table->foreign("notification_id")->references('id')->on('notifications')->onDelete('cascade')->onUpdate('cascade');
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
            $table->dropForeign($this->tablename."_notification_id_foreign");
        });
        Schema::drop($this->tablename);
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTroubleshootActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troubleshoot_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('action')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('description_id')->unsigned();
            $table->foreign('description_id')->references('id')->on('descriptions');
            $table->string('status')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->boolean('is_on_time')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('troubleshoot_actions');
    }
}

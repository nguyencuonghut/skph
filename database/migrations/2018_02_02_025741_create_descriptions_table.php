<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->date('issue_date');
            $table->date('answer_date');
            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->integer('source_id')->unsigned();
            $table->foreign('source_id')->references('id')->on('sources');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');
            $table->string('image');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('leader_id')->unsigned();
            $table->foreign('leader_id')->references('id')->on('users');
            $table->text('what');
            $table->text('why');
            $table->dateTime('when');
            $table->string('who');
            $table->text('where');
            $table->text('how_1');
            $table->integer('how_2')->unsigned();
            $table->text('leader_confirmation_result');
            $table->string('effectiveness');
            $table->integer('effectiveness_user_id')->unsigned();
            $table->foreign('effectiveness_user_id')->references('id')->on('users');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
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
        Schema::drop('descriptions');
    }
}

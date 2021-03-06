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
            $table->string('title')->unique();
            $table->date('issue_date');
            $table->date('answer_date');
            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->integer('source_id')->unsigned();
            $table->foreign('source_id')->references('id')->on('sources');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');
            $table->string('image')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('leader_id')->unsigned();
            $table->foreign('leader_id')->references('id')->on('users');
            $table->text('what')->nullable();
            $table->text('why')->nullable();
            $table->dateTime('when')->nullable();
            $table->string('who')->nullable();
            $table->text('where')->nullable();
            $table->text('how_1')->nullable();
            $table->integer('how_2')->unsigned()->nullable();
            $table->text('leader_confirmation_result')->nullable();
            $table->string('effectiveness')->nullable();
            $table->integer('effectiveness_user_id')->unsigned();
            $table->foreign('effectiveness_user_id')->references('id')->on('users');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->integer('troubleshoot_action_count');
            $table->integer('prevention_action_count');
            $table->boolean('is_troubleshoot_actions_on_time')->default(false);
            $table->boolean('is_prevention_actions_on_time')->default(false);
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

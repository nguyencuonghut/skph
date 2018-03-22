<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposer_id')->unsigned();
            $table->foreign('proposer_id')->references('id')->on('users');
            $table->integer('approver_id')->unsigned();
            $table->foreign('approver_id')->references('id')->on('users');
            $table->string('approve_result')->nullable();
            $table->longText('root_cause')->nullable();
            $table->integer('root_cause_approver_id')->unsigned();
            $table->foreign('root_cause_approver_id')->references('id')->on('users');
            $table->string('root_cause_approve_result')->nullable();
            $table->integer('reason_type_id')->unsigned();
            $table->foreign('reason_type_id')->references('id')->on('reason_types');

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
        Schema::drop('preventions');
    }
}

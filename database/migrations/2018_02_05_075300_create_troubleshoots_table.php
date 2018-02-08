<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTroubleshootsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troubleshoots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('responsibility_id')->unsigned();
            $table->foreign('responsibility_id')->references('id')->on('responsibilities');
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('levels');
            $table->integer('troubleshooter_id')->unsigned();
            $table->foreign('troubleshooter_id')->references('id')->on('users');
            $table->integer('approver_id')->unsigned();
            $table->foreign('approver_id')->references('id')->on('users');
            $table->longText('reason');
            $table->string('approve_result');
            $table->dateTime('deadline');
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
        Schema::drop('troubleshoots');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventionactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prevention_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('action');
            $table->integer('budget');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('where');
            $table->dateTime('when');
            $table->text('how');
            $table->string('status');
            $table->integer('description_id')->unsigned();
            $table->foreign('description_id')->references('id')->on('descriptions');
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
        Schema::dropIfExists('prevention_actions');
    }
}

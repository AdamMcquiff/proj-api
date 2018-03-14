<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iteration_id')->unsigned();
            $table->integer('reporter_id')->unsigned()->nullable();
            $table->integer('assignee_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('summary')->nullable();
            $table->tinyInteger('status');
            $table->date('due_date')->nullable();
            $table->timestamps();

            $table->foreign('iteration_id')
                ->references('id')
                ->on('iterations')
                ->onDelete('cascade');

            $table->foreign('reporter_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('assignee_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_start')->comment('Дата начала');
            $table->timestamp('date_finish')->comment('Дата окончания');
            $table->string('name')->comment('Название');
            $table->string('project')->comment('Проект');
            $table->boolean('is_confirmed')->default(false)->comment('Подтвержден администратором');
            $table->unsignedBigInteger('user_id')->comment('Автор');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

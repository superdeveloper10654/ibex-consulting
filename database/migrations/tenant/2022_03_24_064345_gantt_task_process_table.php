<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GanttTaskProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('gantt_task_process', function (Blueprint $table) {
            $table->id();
            $table->string('task_id')->nullable();
            $table->integer('progress')->nullable();
            $table->dateTime('datetime_recorded')->nullable();
            $table->date('date_recorded')->nullable();
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
        Schema::dropIfExists('gantt_task_process');
    }
}

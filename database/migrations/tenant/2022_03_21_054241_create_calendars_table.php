<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('programme_id')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->string('name')->nullable();
            $table->string('start_time')->default('07:00');
            $table->integer('start_hour')->default(7);
            $table->integer('start_minute')->default(0);
            $table->string('end_time')->default('17:00');
            $table->integer('end_hour')->default(7);
            $table->integer('end_minute')->default(0);
            $table->tinyInteger('working_day_monday')->default(1);
            $table->tinyInteger('working_day_tuesday')->default(1);
            $table->tinyInteger('working_day_wednesday')->default(1);
            $table->tinyInteger('working_day_thursday')->default(1);
            $table->tinyInteger('working_day_friday')->default(1);
            $table->tinyInteger('working_day_saturday')->default(1);
            $table->tinyInteger('working_day_sunday')->default(1);
            $table->tinyInteger('is_default_task_calendar')->default(1);
            $table->tinyInteger('is_default_resource_calendar')->default(1);
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
        Schema::dropIfExists('calendars');
    }
}

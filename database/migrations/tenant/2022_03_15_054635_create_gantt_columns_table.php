<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGanttColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gantt_columns', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('programme_id')->nullable();
            $table->longText('task_columns')->default(DB::raw('(\'[{"status": true,"wbs":false,"text":true,"start_date":true,"end_date":false,"duration_worked":false,"progress":false,"baseline_start":false,"constraint_date":false,"baseline_end":false,"constraint_type":false,"deadline":false,"task_calendar":false,"resource_id":false}]\')'));
              $table->longText('resource_columns')->default(DB::raw('(\'[{"name":true,"resource_calendar":false,"company":true,"notes":false,"cost_rate":true}]\')'));
            $table->integer('wbs')->default(42);
            $table->integer('text')->default(154);
            $table->integer('start_date')->default(110);
            $table->integer('end_date')->default(110);
            $table->integer('progress')->default(80);
            $table->integer('duration_worked')->default(80);
            $table->integer('baseline_start')->default(110);
            $table->integer('baseline_end')->default(110);
            $table->integer('reference_number')->default(80);
            $table->integer('task_calendar')->default(80);
            $table->integer('deadline')->default(110);
            $table->integer('constraint_type')->default(80);
            $table->integer('constraint_date')->default(110);
            $table->integer('comments')->default(80);
            $table->integer('resource_id')->default(110);
            $table->integer('status')->default(40);
            $table->integer('resource_calendar')->default(80);
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
        Schema::dropIfExists('gantt_columns');
    }
}

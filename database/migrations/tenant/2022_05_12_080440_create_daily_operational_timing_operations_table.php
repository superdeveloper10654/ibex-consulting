<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyOperationalTimingOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_operational_timing_operations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('daily_work_record_id')->unsigned();
            $table->foreign('daily_work_record_id','dwr_doto_id')->references('id')->on('daily_work_records');
            $table->bigInteger('operation_id')->unsigned();
            $table->foreign('operation_id','op_doto_id')->references('id')->on('operations');
            $table->text('started')->nullable();
            $table->text('completed')->nullable();
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('daily_operational_timing_operations');
    }
}

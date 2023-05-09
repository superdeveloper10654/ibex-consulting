<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyOperationalTimingSuppliedMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_operational_timing_supplied_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('daily_work_record_id')->unsigned();
            $table->foreign('daily_work_record_id','dwr_dotsm_id')->references('id')->on('daily_work_records');
            $table->bigInteger('material_id')->unsigned();
            $table->foreign('material_id','mat_dotsm_id')->references('id')->on('materials');
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
        Schema::dropIfExists('daily_operational_timing_supplied_materials');
    }
}

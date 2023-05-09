<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyDirectVehiclesAndPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_direct_vehicles_and_plants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('daily_work_record_id')->unsigned();
            $table->foreign('daily_work_record_id','dwr_dvp_id')->references('id')->on('daily_work_records');
            $table->bigInteger('direct_vehicles_and_plant_id')->unsigned();
            $table->foreign('direct_vehicles_and_plant_id','dvp_id')->references('id')->on('direct_vehicles_and_plants');
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
        Schema::dropIfExists('daily_direct_vehicles_and_plants');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySubContractOrHiredVehiclesAndPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_sub_contract_or_hired_vehicles_and_plants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('daily_work_record_id')->unsigned();
            $table->foreign('daily_work_record_id','dwr_sc_hvp_id')->references('id')->on('daily_work_records');
            $table->bigInteger('subcontract_or_hired_vehicles_and_plant_id')->unsigned();
            $table->foreign('subcontract_or_hired_vehicles_and_plant_id','sc_hvp_id')->references('id')->on('subcontract_or_hired_vehicles_and_plants');
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
        Schema::dropIfExists('daily_sub_contract_or_hired_vehicles_and_plants');
    }
}

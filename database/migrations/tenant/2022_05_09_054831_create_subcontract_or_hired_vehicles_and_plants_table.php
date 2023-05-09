<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcontractOrHiredVehiclesAndPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcontract_or_hired_vehicles_and_plants', function (Blueprint $table) {
            $table->id();
            $table->text('vehicle_or_plant_name');
            $table->text('supplier_name');
            $table->text('ref_no');
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
        Schema::dropIfExists('subcontract_or_hired_vehicles_and_plants');
    }
}

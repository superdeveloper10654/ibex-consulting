<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartTwoNec4ContractDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_two_nec4_contract_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');

            $table->text('activity_schedule_is')->nullable();
            $table->text('contractor_elect_address_is')->nullable();
            $table->text('contract_working_areas')->nullable();

            $table->text('completion_date_works')->nullable();
            $table->text('outside_equip_expenses')->nullable();
            $table->text('x10_info_execution_plan')->nullable();
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
        Schema::dropIfExists('part_two_nec4_contract_datas');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartTwoNec4TscContractDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_two_nec4_tsc_contract_datas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('contractor_electronic_address_is')->nullable();
            $table->string('fee_percentage')->nullable();
            $table->string('service_areas_are')->nullable();
            $table->string('senior_representative_name_1')->nullable();
            $table->string('senior_representative_address_1')->nullable();
            $table->string('senior_representative_electronic_address_1')->nullable();
            $table->string('senior_representative_name_2')->nullable();
            $table->string('senior_representative_address_2')->nullable();
            $table->string('senior_representative_electronic_address_2')->nullable();
            $table->string('x10_info_execution_plan')->nullable();
            $table->string('sorter_schedule_shared_service_1')->nullable();
            $table->string('sorter_schedule_shared_service_2')->nullable();
            $table->string('sorter_schedule_shared_service_3')->nullable();
            $table->string('sorter_schedule_shared_service_4')->nullable();
            $table->string('sorter_schedule_shared_service_person_category_1')->nullable();
            $table->string('sorter_schedule_shared_service_person_category_2')->nullable();
            $table->string('sorter_schedule_shared_service_person_category_3')->nullable();
            $table->string('sorter_schedule_shared_service_person_category_4')->nullable();
            $table->string('sorter_schedule_shared_service_rate_1')->nullable();
            $table->string('sorter_schedule_shared_service_rate_2')->nullable();
            $table->string('sorter_schedule_shared_service_rate_3')->nullable();
            $table->string('sorter_schedule_shared_service_rate_4')->nullable();
            $table->string('schedule_equipment_1')->nullable();
            $table->string('schedule_equipment_2')->nullable();
            $table->string('schedule_equipment_3')->nullable();
            $table->string('schedule_equipment_4')->nullable();
            $table->string('schedule_equipment_charge_1')->nullable();
            $table->string('schedule_equipment_charge_2')->nullable();
            $table->string('schedule_equipment_charge_3')->nullable();
            $table->string('schedule_equipment_charge_4')->nullable();
            $table->string('schedule_equipment_time_period_1')->nullable();
            $table->string('schedule_equipment_time_period_2')->nullable();
            $table->string('schedule_equipment_time_period_3')->nullable();
            $table->string('schedule_equipment_time_period_4')->nullable();
            $table->string('special_equipment_text_1')->nullable();
            $table->string('special_equipment_text_2')->nullable();
            $table->string('special_equipment_text_3')->nullable();
            $table->string('special_equipment_text_4')->nullable();
            $table->string('special_equipment_rate_1')->nullable();
            $table->string('special_equipment_rate_2')->nullable();
            $table->string('special_equipment_rate_3')->nullable();
            $table->string('special_equipment_rate_4')->nullable();
            $table->string('schedule_defined_cost_design_text_1')->nullable();
            $table->string('schedule_defined_cost_design_text_2')->nullable();
            $table->string('schedule_defined_cost_design_text_3')->nullable();
            $table->string('schedule_defined_cost_design_text_4')->nullable();
            $table->string('schedule_defined_cost_design_rate_1')->nullable();
            $table->string('schedule_defined_cost_design_rate_2')->nullable();
            $table->string('schedule_defined_cost_design_rate_3')->nullable();
            $table->string('schedule_defined_cost_design_rate_4')->nullable();
            $table->string('schedule_shared_service_1')->nullable();
            $table->string('schedule_shared_service_2')->nullable();
            $table->string('schedule_shared_service_3')->nullable();
            $table->string('schedule_shared_service_4')->nullable();
            $table->string('schedule_shared_service_person_category_1')->nullable();
            $table->string('schedule_shared_service_person_category_2')->nullable();
            $table->string('schedule_shared_service_person_category_3')->nullable();
            $table->string('schedule_shared_service_person_category_4')->nullable();
            $table->string('schedule_shared_service_rate_1')->nullable();
            $table->string('schedule_shared_service_rate_2')->nullable();
            $table->string('schedule_shared_service_rate_3')->nullable();
            $table->string('schedule_shared_service_rate_4')->nullable();
            $table->string('people_rate_person_1')->nullable();
            $table->string('people_rate_person_2')->nullable();
            $table->string('people_rate_person_3')->nullable();
            $table->string('people_rate_person_4')->nullable();
            $table->string('people_rate_unit_1')->nullable();
            $table->string('people_rate_unit_2')->nullable();
            $table->string('people_rate_unit_3')->nullable();
            $table->string('people_rate_unit_4')->nullable();
            $table->string('people_rate_1')->nullable();
            $table->string('people_rate_2')->nullable();
            $table->string('people_rate_3')->nullable();
            $table->string('people_rate_4')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_two_nec4_tsc_contract_datas');
    }
}

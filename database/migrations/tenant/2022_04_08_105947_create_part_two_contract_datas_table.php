<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartTwoContractDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_two_contract_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('contractor_name_is')->nullable();
            $table->text('contractor_address_is')->nullable();
            $table->double('direct_fee')->nullable();
            $table->double('subcontracted_fee')->nullable();
            $table->string('key_people_1_name')->nullable();
            $table->string('key_people_1_job')->nullable();
            $table->string('key_people_1_resp')->nullable();
            $table->string('key_people_1_qual')->nullable();
            $table->string('key_people_1_exp')->nullable();
            $table->string('key_people_2_name')->nullable();
            $table->string('key_people_2_job')->nullable();
            $table->string('key_people_2_resp')->nullable();
            $table->string('key_people_2_qual')->nullable();
            $table->string('key_people_2_exp')->nullable();

            $table->text('contractor_ident_prog')->nullable();
            $table->text('contractor_wi1')->nullable();
            $table->text('contractor_wi2')->nullable();
            $table->text('project_bank')->nullable();
            $table->text('named_suppliers')->nullable();
            $table->text('bill_of_quantities_is')->nullable();
            $table->double('total_prices')->nullable();
            $table->double('people_oh_percent')->nullable();
            $table->text('equipment_publisher')->nullable();
            $table->text('equipment_adj')->nullable();
            $table->string('equipment_text_1')->nullable();
            $table->string('equipment_size_1')->nullable();
            $table->string('equipment_rate_1')->nullable();
            $table->string('equipment_text_2')->nullable();
            $table->string('equipment_size_2')->nullable();
            $table->string('equipment_rate_2')->nullable();
            $table->string('equipment_text_3')->nullable();
            $table->string('equipment_size_3')->nullable();
            $table->string('equipment_rate_3')->nullable();
            $table->string('equipment_text_4')->nullable();
            $table->string('equipment_size_4')->nullable();
            $table->string('equipment_rate_4')->nullable();
            $table->string('defined_cost_design_text_1')->nullable();
            $table->string('defined_cost_design_rate_1')->nullable();
            $table->string('defined_cost_design_text_2')->nullable();
            $table->string('defined_cost_design_rate_2')->nullable();
            $table->string('defined_cost_design_text_3')->nullable();
            $table->string('defined_cost_design_rate_3')->nullable();
            $table->string('defined_cost_design_text_4')->nullable();
            $table->string('defined_cost_design_rate_4')->nullable();
            $table->string('design_oh_percent')->nullable();
            $table->text('design_expenses_cats')->nullable();
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
        Schema::dropIfExists('part_two_contract_datas');
    }
}

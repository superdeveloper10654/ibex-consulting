<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsOfPartTwoContractDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('part_two_contract_datas', function (Blueprint $table) {
            $table->text('contract_working_areas')->before('created_at')->nullable();
            $table->date('completion_date_works')->before('created_at')->nullable();

            $table->dropColumn('contractor_name_is');
            $table->dropColumn('contractor_address_is');
            $table->dropColumn('bill_of_quantities_is');

            $table->dropColumn('key_people_1_name');
            $table->dropColumn('key_people_1_job');
            $table->dropColumn('key_people_1_resp');
            $table->dropColumn('key_people_1_qual');
            $table->dropColumn('key_people_1_exp');
            $table->dropColumn('key_people_2_name');
            $table->dropColumn('key_people_2_job');
            $table->dropColumn('key_people_2_resp');
            $table->dropColumn('key_people_2_qual');
            $table->dropColumn('key_people_2_exp');

            $table->dropColumn('equipment_text_1');
            $table->dropColumn('equipment_size_1');
            $table->dropColumn('equipment_rate_1');
            $table->dropColumn('equipment_text_2');
            $table->dropColumn('equipment_size_2');
            $table->dropColumn('equipment_rate_2');
            $table->dropColumn('equipment_text_3');
            $table->dropColumn('equipment_size_3');
            $table->dropColumn('equipment_rate_3');
            $table->dropColumn('equipment_text_4');
            $table->dropColumn('equipment_size_4');
            $table->dropColumn('equipment_rate_4');

            $table->dropColumn('defined_cost_design_text_1');
            $table->dropColumn('defined_cost_design_rate_1');
            $table->dropColumn('defined_cost_design_text_2');
            $table->dropColumn('defined_cost_design_rate_2');
            $table->dropColumn('defined_cost_design_text_3');
            $table->dropColumn('defined_cost_design_rate_3');
            $table->dropColumn('defined_cost_design_text_4');
            $table->dropColumn('defined_cost_design_rate_4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('part_two_contract_datas', function (Blueprint $table) {
            $table->dropColumn('contract_working_areas');
            $table->dropColumn('completion_date_works');

            $table->string('contractor_name_is')->nullable();
            $table->text('contractor_address_is')->nullable();

            $table->text('bill_of_quantities_is')->nullable();

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
        });
    }
}

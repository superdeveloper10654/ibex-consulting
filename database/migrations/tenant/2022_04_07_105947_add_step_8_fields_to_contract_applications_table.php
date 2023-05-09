<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStep8FieldsToContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('arbitration_proceedure_is')->nullable();
            $table->text('arbitration_place_is')->nullable();
            $table->text('arbitration_chooser_is')->nullable();
            $table->text('completion_date')->nullable();
            $table->text('first_programme_within')->nullable();
            $table->text('condition_1')->nullable();
            $table->text('key_date_1')->nullable();
            $table->text('condition_2')->nullable();
            $table->text('key_date_2')->nullable();
            $table->text('condition_3')->nullable();
            $table->text('key_date_3')->nullable(); 
            
            $table->integer('payment_period_yuk2_number')->nullable();
            $table->text('payment_period_yuk2_text')->nullable();
            $table->integer('payment_period_not_yuk2_number')->nullable();
            $table->text('payment_period_not_yuk2_text')->nullable();

            $table->text('employer_risk_1')->nullable();
            $table->text('employer_risk_2')->nullable();
            $table->text('employer_risk_3')->nullable();
            $table->text('employer_insurance_plant_materials')->nullable();
            $table->text('employer_insurance_table_insurance_against_1')->nullable();
            $table->text('employer_insurance_table_indemnity_is_1')->nullable();
            $table->text('employer_insurance_table_deductibles_1')->nullable();
            $table->text('employer_insurance_table_insurance_against_2')->nullable();
            $table->text('employer_insurance_table_indemnity_is_2')->nullable();
            $table->text('employer_insurance_table_deductibles_2')->nullable();
            $table->text('employer_insurance_table_insurance_against_3')->nullable();
            $table->text('employer_insurance_table_indemnity_is_3')->nullable();
            $table->text('employer_insurance_table_deductibles_3')->nullable();

            $table->text('employer_insurance_additional_against_1')->nullable();
            $table->text('employer_insurance_additional_indemnity_is_1')->nullable();
            $table->text('employer_insurance_additional_deductibles_1')->nullable();
            $table->text('employer_insurance_additional_against_2')->nullable();
            $table->text('employer_insurance_additional_indemnity_is_2')->nullable();
            $table->text('employer_insurance_additional_deductibles_2')->nullable();
            $table->text('employer_insurance_additional_against_3')->nullable();
            $table->text('employer_insurance_additional_indemnity_is_3')->nullable();
            $table->text('employer_insurance_additional_deductibles_3')->nullable();

            $table->text('contractor_insurance_additional_against_1')->nullable();
            $table->text('contractor_insurance_additional_indemnity_is_1')->nullable();
            $table->text('contractor_insurance_additional_deductibles_1')->nullable();
            $table->text('contractor_insurance_additional_against_2')->nullable();
            $table->text('contractor_insurance_additional_indemnity_is_2')->nullable();
            $table->text('contractor_insurance_additional_deductibles_2')->nullable();
            $table->text('contractor_insurance_additional_against_3')->nullable();
            $table->text('contractor_insurance_additional_indemnity_is_3')->nullable();
            $table->text('contractor_insurance_additional_deductibles_3')->nullable();

            $table->text('method_of_measurement_is')->nullable();
            $table->text('method_of_measurement_amendments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->dropColumn('arbitration_proceedure_is');
            $table->dropColumn('arbitration_place_is');
            $table->dropColumn('arbitration_chooser_is');
            $table->dropColumn('completion_date');
            $table->dropColumn('first_programme_within');
            $table->dropColumn('condition_1');
            $table->dropColumn('key_date_1');
            $table->dropColumn('condition_2');
            $table->dropColumn('key_date_2');
            $table->dropColumn('condition_3');
            $table->dropColumn('key_date_3');

            $table->dropColumn('payment_period_yuk2_number');
            $table->dropColumn('payment_period_yuk2_text');
            $table->dropColumn('payment_period_not_yuk2_number');
            $table->dropColumn('payment_period_not_yuk2_text');

            $table->dropColumn('employer_risk_1');
            $table->dropColumn('employer_risk_2');
            $table->dropColumn('employer_risk_3');
            $table->dropColumn('employer_insurance_plant_materials');
            $table->dropColumn('employer_insurance_table_insurance_against_1');
            $table->dropColumn('employer_insurance_table_indemnity_is_1');
            $table->dropColumn('employer_insurance_table_deductibles_1');
            $table->dropColumn('employer_insurance_table_insurance_against_2');
            $table->dropColumn('employer_insurance_table_indemnity_is_2');
            $table->dropColumn('employer_insurance_table_deductibles_2');
            $table->dropColumn('employer_insurance_table_insurance_against_3');
            $table->dropColumn('employer_insurance_table_indemnity_is_3');
            $table->dropColumn('employer_insurance_table_deductibles_3');

            $table->dropColumn('employer_insurance_additional_against_1');
            $table->dropColumn('employer_insurance_additional_indemnity_is_1');
            $table->dropColumn('employer_insurance_additional_deductibles_1');
            $table->dropColumn('employer_insurance_additional_against_2');
            $table->dropColumn('employer_insurance_additional_indemnity_is_2');
            $table->dropColumn('employer_insurance_additional_deductibles_2');
            $table->dropColumn('employer_insurance_additional_against_3');
            $table->dropColumn('employer_insurance_additional_indemnity_is_3');
            $table->dropColumn('employer_insurance_additional_deductibles_3');

            $table->dropColumn('contractor_insurance_additional_against_1');
            $table->dropColumn('contractor_insurance_additional_indemnity_is_1');
            $table->dropColumn('contractor_insurance_additional_deductibles_1');
            $table->dropColumn('contractor_insurance_additional_against_2');
            $table->dropColumn('contractor_insurance_additional_indemnity_is_2');
            $table->dropColumn('contractor_insurance_additional_deductibles_2');
            $table->dropColumn('contractor_insurance_additional_against_3');
            $table->dropColumn('contractor_insurance_additional_indemnity_is_3');
            $table->dropColumn('contractor_insurance_additional_deductibles_3');

            $table->dropColumn('method_of_measurement_is');
            $table->dropColumn('method_of_measurement_amendments');

        });
    }
}

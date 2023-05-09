<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveContractInsuranceFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->dropColumn('employer_risk_1');
            $table->dropColumn('employer_risk_2');
            $table->dropColumn('employer_risk_3');
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
            $table->text('employer_risk_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_risk_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_risk_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_insurance_against_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_indemnity_is_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_deductibles_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_insurance_against_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_indemnity_is_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_deductibles_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_insurance_against_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_indemnity_is_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_table_deductibles_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_against_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_indemnity_is_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_deductibles_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_against_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_indemnity_is_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_deductibles_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_against_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_indemnity_is_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('employer_insurance_additional_deductibles_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_against_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_indemnity_is_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_deductibles_1');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_against_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_indemnity_is_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_deductibles_2');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_against_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_indemnity_is_3');
        });
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('contractor_insurance_additional_deductibles_3');
        });
    }
}

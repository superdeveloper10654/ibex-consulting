<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNec4TscContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nec4_tsc_contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('employer_electronic_address_is')->nullable();
            $table->string('adj_electronic_address_is')->nullable();
            $table->string('senior_representative_name_1')->nullable();
            $table->string('senior_representative_name_2')->nullable();
            $table->string('senior_representative_address_1')->nullable();
            $table->string('senior_representative_address_2')->nullable();
            $table->string('senior_representative_electronic_address_1')->nullable();
            $table->string('senior_representative_electronic_address_2')->nullable();
            $table->string('indices_are')->nullable();
            $table->string('inflation_adjustment_dates')->nullable();
            $table->string('undertakings_provide_to_1')->nullable();
            $table->string('undertakings_provide_to_2')->nullable();
            $table->string('subcontractor_undertakings_works_1')->nullable();
            $table->string('subcontractor_undertakings_works_2')->nullable();
            $table->string('subcontractor_undertakings_provide_to_1')->nullable();
            $table->string('subcontractor_undertakings_provide_to_2')->nullable();
            $table->string('subcontractor_undertakings_client_works_1')->nullable();
            $table->string('subcontractor_undertakings_client_works_2')->nullable();
            $table->string('x10_info_exec_plan_period')->nullable();
            $table->string('x10_min_insurance_amount')->nullable();
            $table->string('x10_service_period_end')->nullable();
            $table->string('x12_promoter_is')->nullable();
            $table->string('x12_shedule_is_in')->nullable();
            $table->string('x12_promortors_objective')->nullable();
            $table->string('x19_min_service_period')->nullable();
            $table->string('x19_notice_period')->nullable();
            $table->string('x23_max_period')->nullable();
            $table->string('sm_electronic_address_is')->nullable();
            $table->string('outside_works_information')->nullable();
            $table->string('except_period_for_reply_for_1')->nullable();
            $table->string('except_period_for_reply_is_1')->nullable();
            $table->string('except_period_for_reply_for_2')->nullable();
            $table->string('except_period_for_reply_is_2')->nullable();
            $table->string('early_warnings_no_longer_than')->nullable();
            $table->string('quality_policy_plan_period')->nullable();
            $table->string('revised_plans_interval_no_longer_than')->nullable();
            $table->string('end_task_order_programme_period')->nullable();
            $table->string('final_assessment_period')->nullable();
            $table->string('a_value_engineering_percentage')->nullable();
            $table->string('additional_compansation_events')->nullable();
            $table->string('x23_extension_period_1')->nullable();
            $table->date('x23_notice_date_1')->nullable();
            $table->string('x23_extension_period_2')->nullable();
            $table->date('x23_notice_date_2')->nullable();
            $table->string('x23_extension_period_3')->nullable();
            $table->date('x23_notice_date_3')->nullable();
            $table->string('x23_extension_period_4')->nullable();
            $table->date('x23_notice_date_4')->nullable();
            $table->string('x23_extension_criteria_1')->nullable();
            $table->string('x23_extension_criteria_2')->nullable();
            $table->string('x23_extension_criteria_3')->nullable();
            $table->string('x24_account_period_1')->nullable();
            $table->string('x24_account_period_2')->nullable();
            $table->string('x24_account_period_3')->nullable();
            $table->string('yuk2_accounting_period',)->nullable();
            $table->string('yuk2_due_payment_period')->nullable();
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
        Schema::dropIfExists('nec4_tsc_contracts');
    }
}

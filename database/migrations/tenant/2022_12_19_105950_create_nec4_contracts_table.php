<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNec4ContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nec4_contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');

            $table->text('inflation_adjustment_dates')->nullable();

            $table->boolean('is_takeover_completion_date')->default(0);
            $table->text('takeover_completion_date')->nullable();

            $table->text('x10_info_exec_plan_period')->nullable();
            $table->text('x10_min_insurance_amount')->nullable();
            $table->text('x10_service_period_end')->nullable();

            $table->text('x12_shedule_is_in')->nullable();

            $table->text('x15_retention_period')->nullable();
            $table->text('x15_min_insurance_amount')->nullable();
            $table->text('x15_completion_or_termination_period')->nullable();

            $table->text('x16_retention_bond')->nullable();

            $table->text('x19_min_service_period')->nullable();
            $table->text('x19_notice_period')->nullable();
            $table->text('x23_max_period')->nullable();
            $table->text('outside_works_information')->nullable();
            $table->text('early_warnings_no_longer_than')->nullable();
            $table->text('revised_plans_interval_no_longer_than')->nullable();
            $table->text('end_task_order_programme_period')->nullable();
            $table->text('quality_policy_plan_period')->nullable();
            $table->text('final_assessment_period')->nullable();
            $table->text('a_value_engineering_percentage')->nullable();
            $table->text('additional_compansation_events')->nullable();

            $table->text('yuk2_accounting_period')->nullable();
            $table->text('yuk2_due_payment_period')->nullable();

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
        Schema::dropIfExists('nec4_contracts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTscContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsc_contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('service_is')->nullable();
            $table->string('sm_name_is')->nullable();
            $table->string('sm_address_is')->nullable();
            $table->string('affected_property_is')->nullable();
            $table->string('service_period_is')->nullable();
            $table->string('insurance_min_amount_to_emp_prop')->nullable();
            $table->string('insurance_min_amount_of_damage_prop')->nullable();
            $table->string('insurance_min_limit_indemnity')->nullable();

            $table->integer('payment_period_ynz1_number')->nullable();
            $table->string('payment_period_ynz1_text')->nullable();

            $table->integer('max_prepare_forcast_week_interval')->nullable();
            $table->float('share_range_less_than')->nullable();
            $table->float('share_range_greater_than')->nullable();
            $table->float('share_range_from_1')->nullable();
            $table->float('share_range_from_2')->nullable();
            $table->float('share_range_to_1')->nullable();
            $table->float('share_range_to_2')->nullable();
            $table->float('less_than_share_percentage')->nullable();
            $table->float('greater_than_share_percentage')->nullable();
            $table->float('from_to_share_percentage_1')->nullable();
            $table->float('from_to_share_percentage_2')->nullable();
            $table->text('share_assesed_on')->nullable();
            $table->string('ce_exchange_rates_text')->nullable();
            $table->date('ce_exchange_rates_date')->nullable();
            $table->text('activity_1')->nullable();
            $table->text('activity_2')->nullable();
            $table->text('activity_3')->nullable();
            $table->text('activity_4')->nullable();
            $table->text('other_currency_1')->nullable();
            $table->text('other_currency_2')->nullable();
            $table->text('other_currency_3')->nullable();
            $table->text('other_currency_4')->nullable();
            $table->float('total_max_payment_1')->nullable();
            $table->float('total_max_payment_2')->nullable();
            $table->float('total_max_payment_3')->nullable();
            $table->float('total_max_payment_4')->nullable();
            $table->text('x17_slt')->nullable();
            $table->integer('x19_end_task_order_programme_days_number')->nullable();
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
        Schema::dropIfExists('tsc_contracts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStep9FieldsToContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->double('paf_1_number')->nullable();
            $table->text('paf_1_text')->nullable();
            $table->double('paf_2_number')->nullable();
            $table->text('paf_2_text')->nullable();
            $table->double('paf_3_number')->nullable();
            $table->text('paf_3_text')->nullable();
            $table->double('paf_4_number')->nullable();
            $table->text('paf_4_text')->nullable();
            $table->double('paf_5_number')->nullable();
            $table->text('paf_5_text')->nullable();
            $table->double('paf_6_number')->nullable();
            $table->text('paf_6_text')->nullable();
            $table->double('paf_7')->nullable();

            $table->text('base_date')->nullable();
            $table->text('indices_prepared_by')->nullable();
            $table->text('items_activities_employer_pay_1')->nullable();
            $table->text('other_currency_employer_pay_1')->nullable();
            $table->text('max_currency_employer_pay_1')->nullable();
            $table->text('exchange_rates_text')->nullable();
            $table->text('exchange_rates_date')->nullable();
            $table->text('completion_date_1_text')->nullable();
            $table->text('completion_date_1')->nullable();
            $table->text('completion_date_2_text')->nullable();
            $table->text('completion_date_2')->nullable();
            $table->text('completion_date_3_text')->nullable();
            $table->text('completion_date_3')->nullable();
            $table->text('completion_date_4_text')->nullable();
            $table->text('completion_date_4')->nullable();

            $table->text('bonus_1_text')->nullable();
            $table->integer('bonus_1_number')->nullable();
            $table->text('bonus_2_text')->nullable();
            $table->integer('bonus_2_number')->nullable();
            $table->text('bonus_3_text')->nullable();
            $table->integer('bonus_3_number')->nullable();
            $table->text('bonus_4_text')->nullable();
            $table->integer('bonus_4_number')->nullable();
            $table->text('bonus_remainder_number')->nullable();

            $table->text('delay_damages_1_text')->nullable();
            $table->text('delay_damages_1_number')->nullable();
            $table->text('delay_damages_2_text')->nullable();
            $table->text('delay_damages_2_number')->nullable();
            $table->text('delay_damages_3_text')->nullable();
            $table->text('delay_damages_3_number')->nullable();
            $table->text('delay_damages_4_text')->nullable();
            $table->text('delay_damages_4_number')->nullable();
            $table->text('delay_damages_remainder_number')->nullable();

            $table->text('x6_bonus_number')->nullable();
            $table->text('x7_delay_damages_number')->nullable();
            $table->text('x12_client_is')->nullable();
            $table->text('x12_client_objective_is')->nullable();
            $table->text('x12_partnering_information_in')->nullable();
            $table->text('x13_performance_bond')->nullable();
            $table->text('x14_advanced_payment')->nullable();
            $table->text('x14_instalments_weeks')->nullable();
            $table->text('x14_instalments_amount')->nullable();
            $table->text('x14_instalments_percent')->nullable();
            $table->text('x14_bond')->nullable();

            $table->text('x16_retention_free_amount')->nullable();
            $table->text('x16_retention_percent')->nullable();
            $table->text('x17_damages_1_number')->nullable();
            $table->text('x17_damages_1_text')->nullable();
            $table->text('x17_damages_2_number')->nullable();
            $table->text('x17_damages_2_text')->nullable();
            $table->text('x17_damages_3_number')->nullable();
            $table->text('x17_damages_3_text')->nullable();
            $table->text('x17_damages_4_number')->nullable();
            $table->text('x17_damages_4_text')->nullable();

            $table->text('x18_indirect_loss')->nullable();
            $table->text('x18_loss_damage1')->nullable();
            $table->text('x18_loss_damage2')->nullable();
            $table->text('x18_loss_damage3')->nullable();
            $table->text('x17_end_liability_number')->nullable();
            $table->text('x20_incentive_schedule')->nullable();
            $table->text('x20_kpi_number')->nullable();
            $table->text('yuk1_pay_any_charge')->nullable();

            $table->text('yuk3_term_text_1')->nullable();
            $table->text('yuk3_term_text_person_1')->nullable();
            $table->text('yuk3_term_text_2')->nullable();
            $table->text('yuk3_term_text_person_2')->nullable();
            $table->text('yuk3_term_text_3')->nullable();
            $table->text('yuk3_term_text_person_3')->nullable();
            $table->text('yuk3_term_text_4')->nullable();
            $table->text('yuk3_term_text_person_4')->nullable();
            $table->text('add_cond_z1')->nullable();
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
            $table->dropColumn('paf_1_number');
            $table->dropColumn('paf_1_text');
            $table->dropColumn('paf_2_number');
            $table->dropColumn('paf_2_text');
            $table->dropColumn('paf_3_number');
            $table->dropColumn('paf_3_text');
            $table->dropColumn('paf_4_number');
            $table->dropColumn('paf_4_text');
            $table->dropColumn('paf_5_number');
            $table->dropColumn('paf_5_text');
            $table->dropColumn('paf_6_number');
            $table->dropColumn('paf_6_text');
            $table->dropColumn('paf_7');

            $table->dropColumn('base_date');
            $table->dropColumn('indices_prepared_by');
            $table->dropColumn('items_activities_employer_pay_1');
            $table->dropColumn('other_currency_employer_pay_1');
            $table->dropColumn('max_currency_employer_pay_1');
            $table->dropColumn('exchange_rates_text');
            $table->dropColumn('exchange_rates_date');
            $table->dropColumn('completion_date_1_text');
            $table->dropColumn('completion_date_1');
            $table->dropColumn('completion_date_2_text');
            $table->dropColumn('completion_date_2');
            $table->dropColumn('completion_date_3_text');
            $table->dropColumn('completion_date_3');
            $table->dropColumn('completion_date_4_text');
            $table->dropColumn('completion_date_4');

            $table->dropColumn('bonus_1_text');
            $table->dropColumn('bonus_1_number');
            $table->dropColumn('bonus_2_text');
            $table->dropColumn('bonus_2_number');
            $table->dropColumn('bonus_3_text');
            $table->dropColumn('bonus_3_number');
            $table->dropColumn('bonus_4_text');
            $table->dropColumn('bonus_4_number');
            $table->dropColumn('bonus_remainder_number');

            $table->dropColumn('delay_damages_1_text');
            $table->dropColumn('delay_damages_1_number');
            $table->dropColumn('delay_damages_2_text');
            $table->dropColumn('delay_damages_2_number');
            $table->dropColumn('delay_damages_3_text');
            $table->dropColumn('delay_damages_3_number');
            $table->dropColumn('delay_damages_4_text');
            $table->dropColumn('delay_damages_4_number');
            $table->dropColumn('delay_damages_remainder_number');

            $table->dropColumn('x6_bonus_number');
            $table->dropColumn('x7_delay_damages_number');
            $table->dropColumn('x12_client_is');
            $table->dropColumn('x12_client_objective_is');
            $table->dropColumn('x12_partnering_information_in');
            $table->dropColumn('x13_performance_bond');
            $table->dropColumn('x14_advanced_payment');
            $table->dropColumn('x14_instalments_weeks');
            $table->dropColumn('x14_instalments_amount');
            $table->dropColumn('x14_instalments_percent');
            $table->dropColumn('x14_bond');

            $table->dropColumn('x16_retention_free_amount');
            $table->dropColumn('x16_retention_percent');
            $table->dropColumn('x17_damages_1_number');
            $table->dropColumn('x17_damages_1_text');
            $table->dropColumn('x17_damages_2_number');
            $table->dropColumn('x17_damages_2_text');
            $table->dropColumn('x17_damages_3_number');
            $table->dropColumn('x17_damages_3_text');
            $table->dropColumn('x17_damages_4_number');
            $table->dropColumn('x17_damages_4_text');

            $table->dropColumn('x18_indirect_loss');
            $table->dropColumn('x18_loss_damage1');
            $table->dropColumn('x18_loss_damage2');
            $table->dropColumn('x18_loss_damage3');
            $table->dropColumn('x17_end_liability_number');
            $table->dropColumn('x20_incentive_schedule');
            $table->dropColumn('x20_kpi_number');
            $table->dropColumn('yuk1_pay_any_charge');

            $table->dropColumn('yuk3_term_text_1');
            $table->dropColumn('yuk3_term_text_person_1');
            $table->dropColumn('yuk3_term_text_2');
            $table->dropColumn('yuk3_term_text_person_2');
            $table->dropColumn('yuk3_term_text_3');
            $table->dropColumn('yuk3_term_text_person_3');
            $table->dropColumn('yuk3_term_text_4');
            $table->dropColumn('yuk3_term_text_person_4');
            $table->dropColumn('add_cond_z1');
        });
    }
}

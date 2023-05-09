<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsOfContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {

            //step 2
            $table->boolean('sec_opt_X23')->before('created_at')->default(0);
            $table->boolean('sec_opt_X24')->before('created_at')->default(0);

            //step 3
            $table->dropColumn('employer_name_is');
            $table->dropColumn('employer_address_is');
            $table->dropColumn('pm_name_is');
            $table->dropColumn('pm_address_is');
            $table->dropColumn('sup_name_is');
            $table->dropColumn('sup_address_is');
            $table->dropColumn('adj_name_is');
            $table->dropColumn('adj_address_is');

            $table->longText('subcontract_works_are')->before('created_at')->nullable();

            $table->bigInteger('employer_or_client_id')->unsigned()->before('created_at')->nullable();
            $table->foreign('employer_or_client_id')->references('id')->on('profiles');
            $table->bigInteger('pm_or_sm_id')->unsigned()->before('created_at')->nullable();
            $table->foreign('pm_or_sm_id')->references('id')->on('profiles');
            $table->bigInteger('sup_id')->unsigned()->before('created_at')->nullable();
            $table->foreign('sup_id')->references('id')->on('profiles');
            $table->bigInteger('adj_id')->unsigned()->before('created_at')->nullable();
            $table->foreign('adj_id')->references('id')->on('profiles');
            $table->bigInteger('sub_adj_id')->unsigned()->before('created_at')->nullable();
            $table->foreign('sub_adj_id')->references('id')->on('profiles');

            $table->string('affected_property_is')->before('created_at')->nullable();

            //step 4
            $table->integer('subcontractor_period_for_reply_is')->before('created_at')->nullable();

            //step 5
            $table->dropColumn('access_site_part_1');
            $table->dropColumn('access_date_1');
            $table->dropColumn('access_site_part_2');
            $table->dropColumn('access_date_2');
            $table->dropColumn('access_site_part_3');
            $table->dropColumn('access_date_3');

            $table->string('service_period_is')->before('created_at')->nullable();

            //step 6
            $table->dropColumn('defect_correction_period_exception_1_text');
            $table->dropColumn('defect_correction_period_exception_1_number');
            $table->dropColumn('defect_correction_period_exception_2_text');
            $table->dropColumn('defect_correction_period_exception_2_number');

            //step 7 / 8
            $table->float('insurance_min_amount_to_emp_prop')->before('created_at')->nullable();

            //step 8
            $table->dropColumn('condition_1');
            $table->dropColumn('key_date_1');
            $table->dropColumn('condition_2');
            $table->dropColumn('key_date_2');
            $table->dropColumn('condition_3');
            $table->dropColumn('key_date_3');

            $table->integer('ynz1_payment_period')->before('created_at')->nullable();
            $table->integer('max_prepare_forcast_week_interval')->before('created_at')->nullable();

            //step 9
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
            $table->dropColumn('items_activities_employer_pay_1');
            $table->dropColumn('other_currency_employer_pay_1');
            $table->dropColumn('max_currency_employer_pay_1');
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
            $table->dropColumn('delay_damages_1_text');
            $table->dropColumn('delay_damages_1_number');
            $table->dropColumn('delay_damages_2_text');
            $table->dropColumn('delay_damages_2_number');
            $table->dropColumn('delay_damages_3_text');
            $table->dropColumn('delay_damages_3_number');
            $table->dropColumn('delay_damages_4_text');
            $table->dropColumn('delay_damages_4_number');
            $table->dropColumn('x14_instalments_amount');
            $table->dropColumn('x14_instalments_percent');
            $table->dropColumn('x17_damages_1_number');
            $table->dropColumn('x17_damages_1_text');
            $table->dropColumn('x17_damages_2_number');
            $table->dropColumn('x17_damages_2_text');
            $table->dropColumn('x17_damages_3_number');
            $table->dropColumn('x17_damages_3_text');
            $table->dropColumn('x17_damages_4_number');
            $table->dropColumn('x17_damages_4_text');
            $table->dropColumn('yuk3_term_text_1');
            $table->dropColumn('yuk3_term_text_person_1');
            $table->dropColumn('yuk3_term_text_2');
            $table->dropColumn('yuk3_term_text_person_2');
            $table->dropColumn('yuk3_term_text_3');
            $table->dropColumn('yuk3_term_text_person_3');
            $table->dropColumn('yuk3_term_text_4');
            $table->dropColumn('yuk3_term_text_person_4');

            $table->float('share_range_less_than')->before('created_at')->nullable();
            $table->float('less_than_share_percentage')->before('created_at')->nullable();
            $table->float('share_range_from_1')->before('created_at')->nullable();
            $table->float('share_range_to_1')->before('created_at')->nullable();
            $table->float('from_to_share_percentage_1')->before('created_at')->nullable();
            $table->float('share_range_from_2')->before('created_at')->nullable();
            $table->float('share_range_to_2')->before('created_at')->nullable();
            $table->float('from_to_share_percentage_2')->before('created_at')->nullable();
            $table->float('share_range_greater_than')->before('created_at')->nullable();
            $table->float('greater_than_share_percentage')->before('created_at')->nullable();
            $table->text('share_assesed_on')->before('created_at')->nullable();
            $table->text('x3_exchange_rates_text')->before('created_at')->nullable();
            $table->text('x3_exchange_rates_date')->before('created_at')->nullable();
            $table->text('x12_shedule_is_in')->before('created_at')->nullable();
            $table->float('x14_instalments_amount_or_percentage')->before('created_at')->nullable();
            $table->text('x17_slt')->before('created_at')->nullable();
            $table->integer('x19_end_task_order_programme_days_number')->before('created_at')->nullable();
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
        });
    }
}

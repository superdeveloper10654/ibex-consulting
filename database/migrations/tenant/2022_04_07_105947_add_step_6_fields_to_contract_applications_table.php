<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStep6FieldsToContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('defects_date')->nullable();
            $table->integer('defect_correction_period')->nullable();
            $table->text('defect_correction_period_exception_1_text')->nullable();
            $table->integer('defect_correction_period_exception_1_number')->nullable();
            $table->text('defect_correction_period_exception_2_text')->nullable();
            $table->integer('defect_correction_period_exception_2_number')->nullable();

            $table->text('currency_is')->nullable();
            $table->text('assessment_interval')->nullable();
            $table->text('interest_rate_percentage')->nullable();
            $table->text('interest_rate_text_1')->nullable();
            $table->text('interest_rate_text_2')->nullable();
           
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
            $table->dropColumn('defects_date');
            $table->dropColumn('defect_correction_period');
            $table->dropColumn('defect_correction_period_exception_1_text');
            $table->dropColumn('defect_correction_period_exception_1_number');
            $table->dropColumn('defect_correction_period_exception_2_text');
            $table->dropColumn('defect_correction_period_exception_2_number');

            $table->dropColumn('currency_is');
            $table->dropColumn('assessment_interval');
            $table->dropColumn('interest_rate_percentage');
            $table->dropColumn('interest_rate_text_1');
            $table->dropColumn('interest_rate_text_2');
        });
    }
}

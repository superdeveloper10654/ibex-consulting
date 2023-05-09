<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStep4FieldsToContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('works_information_is_in')->nullable();
            $table->text('site_information_is_in')->nullable();
            $table->text('wi100')->nullable();
            $table->text('wi200')->nullable();
            $table->text('wi300')->nullable();
            $table->text('wi400')->nullable();
            $table->text('wi500')->nullable();
            $table->text('wi600')->nullable();
            $table->text('wi700')->nullable();
            $table->text('wi800')->nullable();
            $table->text('wi900')->nullable();
            $table->text('wi1000')->nullable();
            $table->text('wi1100')->nullable();
            $table->text('wi1200')->nullable();
            $table->text('wi1300')->nullable();
            $table->text('wi2000')->nullable();
            $table->text('boundaries_are')->nullable();
            $table->text('language_is')->nullable();
            $table->text('law_is')->nullable();
            $table->text('period_for_reply_is')->nullable();
            $table->text('adjudicator_body_is')->nullable();
            $table->text('tribunal_is')->nullable();
            $table->text('risk_register_matters_are')->nullable(); 
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
            $table->dropColumn('works_information_is_in');
            $table->dropColumn('site_information_is_in');
            $table->dropColumn('wi100');
            $table->dropColumn('wi200');
            $table->dropColumn('wi300');
            $table->dropColumn('wi400');
            $table->dropColumn('wi500');
            $table->dropColumn('wi600');
            $table->dropColumn('wi700');
            $table->dropColumn('wi800');
            $table->dropColumn('wi900');
            $table->dropColumn('wi1000');
            $table->dropColumn('wi1100');
            $table->dropColumn('wi1200');
            $table->dropColumn('wi1300');
            $table->dropColumn('wi2000');  
            $table->dropColumn('boundaries_are');
            $table->dropColumn('language_is');
            $table->dropColumn('law_is');
            $table->dropColumn('period_for_reply_is');
            $table->dropColumn('adjudicator_body_is');
            $table->dropColumn('tribunal_is');
            $table->dropColumn('risk_register_matters_are'); 
        });
    }
}

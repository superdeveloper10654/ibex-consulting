<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecondaryOptionsFieldsToNec4TscContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nec4_tsc_contracts', function (Blueprint $table) {
            $table->integer('sec_opt_X24')->nullable()->after('subcontractor_undertakings_client_works_2');
            $table->integer('sec_opt_X23')->nullable()->after('subcontractor_undertakings_client_works_2');
            $table->integer('x24_account_period_4')->nullable()->after('x24_account_period_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nec4_tsc_contracts', function (Blueprint $table) {
            $table->dropColumn('sec_opt_X24');
            $table->dropColumn('sec_opt_X23');
            $table->dropColumn('x24_account_period_4');
        });
    }
}

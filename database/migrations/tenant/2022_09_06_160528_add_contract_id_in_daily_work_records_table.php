<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractIdInDailyWorkRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_work_records', function (Blueprint $table) {
            $table->dropColumn('contract_or_wbs_no');
            $table->addColumn('integer', 'contract_id')
                ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_work_records', function (Blueprint $table) {
            $table->dropColumn('contract_id');
            $table->addColumn('integer', 'contract_or_wbs_no')
                ->after('id');
        });
    }
}

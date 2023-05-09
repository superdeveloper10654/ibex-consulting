<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsOfPartTwoContractDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('part_two_contract_datas', function (Blueprint $table) {
            //step 3
            $table->text('manufacture_fab_oh')->before('created_at')->nullable();
            $table->text('percent_work_area_oh')->before('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('part_two_contract_datas', function (Blueprint $table) {
            $table->dropColumn('manufacture_fab_oh')->before('created_at');
            $table->dropColumn('percent_work_area_oh')->before('created_at');
        });
    }
}

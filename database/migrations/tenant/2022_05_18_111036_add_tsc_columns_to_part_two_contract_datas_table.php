<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTscColumnsToPartTwoContractDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('part_two_contract_datas', function (Blueprint $table) {
            $table->text('risk_register')->nullable();
            $table->text('contractor_plan_service_info')->nullable();
            $table->text('contractor_ident_plan')->nullable();
            $table->text('price_list')->nullable();
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
            $table->dropColumn([
                'risk_register',
                'contractor_plan_service_info',
                'contractor_ident_plan',
                'price_list',
            ]);
        });
    }
}

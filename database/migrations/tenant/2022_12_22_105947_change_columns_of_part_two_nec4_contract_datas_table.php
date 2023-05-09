<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsOfPartTwoNec4ContractDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('part_two_nec4_contract_datas', function (Blueprint $table) {
            $table->dropColumn('contract_working_areas');
            $table->dropColumn('completion_date_works');
            $table->dropColumn('contractor_elect_address_is');
            $table->dropColumn('outside_equip_expenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('part_two_nec4_contract_datas', function (Blueprint $table) {
            $table->text('contract_working_areas')->nullable();
            $table->text('completion_date_works')->before('created_at')->nullable();
            $table->text('contractor_elect_address_is')->nullable();
            $table->text('outside_equip_expenses')->nullable();
        });
    }
}

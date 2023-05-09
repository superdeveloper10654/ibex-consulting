<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ADDColumnToPartTwoNec4ContractDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('part_two_nec4_contract_datas', function (Blueprint $table) {
            $table->text('employer_electronic_address_is')->nullable();
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
            $table->dropColumn('employer_electronic_address_is');
        });
    }
}

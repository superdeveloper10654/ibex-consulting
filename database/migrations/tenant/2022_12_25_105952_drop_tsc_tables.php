<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTscTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tsc_contracts');
        Schema::dropIfExists('nec4_tsc_contracts');
        Schema::dropIfExists('part_two_nec4_tsc_contract_datas');
        Schema::dropIfExists('part_two_ecs_contract_datas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}

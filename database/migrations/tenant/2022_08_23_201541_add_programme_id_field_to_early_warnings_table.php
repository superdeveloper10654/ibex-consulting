<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProgrammeIdFieldToEarlyWarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('early_warnings', function (Blueprint $table) {
            $table->dropColumn('task_order_id');
            $table->integer('contract_id')
                ->after('works_id');
            $table->integer('programme_id')
                ->after('works_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('early_warnings', function (Blueprint $table) {
            //
        });
    }
}

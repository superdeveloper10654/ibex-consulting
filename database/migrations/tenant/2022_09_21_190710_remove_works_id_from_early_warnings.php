<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveWorksIdFromEarlyWarnings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('early_warnings', function (Blueprint $table) {
            $table->dropColumn('works_id');
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
            $table->addColumn('integer', 'works_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWorkRecordsProfilesFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_work_records', function(Blueprint $table) {
            $table->dropColumn(['client_name', 'supervisor']);
            $table->addColumn('integer', 'client_profile_id', [
                'after'     => 'contract_id',
                'default'   => 2,
            ]);
            $table->addColumn('integer', 'supervisor_profile_id', [
                'after'     => 'site_name',
                'default'   => 2,
            ]);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_work_records', function(Blueprint $table) {
            $table->dropColumn(['client_name', 'supervisor']);
            $table->addColumn('integer', 'client_profile_id', [
                'after' => 'contract_id',
            ]);
            $table->addColumn('integer', 'supervisor_profile_id', [
                'after' => 'site_name',
            ]);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStep5FieldsToContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->text('starting_date')->nullable();
            $table->text('access_site_part_1')->nullable();
            $table->text('access_date_1')->nullable();
            $table->text('access_site_part_2')->nullable();
            $table->text('access_date_2')->nullable();
            $table->text('access_site_part_3')->nullable();
            $table->text('access_date_3')->nullable();
            $table->text('programme_interval_is')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->dropColumn('starting_date');
            $table->dropColumn('access_site_part_1');
            $table->dropColumn('access_date_1');
            $table->dropColumn('access_site_part_2');
            $table->dropColumn('access_date_2');
            $table->dropColumn('access_site_part_3');
            $table->dropColumn('access_date_3');
            $table->dropColumn('programme_interval_is');
        });
    }
}

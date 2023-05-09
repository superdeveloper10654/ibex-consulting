<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStep3FieldsToContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->string('works_are')->nullable();
            $table->string('employer_name_is')->nullable();
            $table->string('employer_address_is')->nullable();
            $table->string('pm_name_is')->nullable();
            $table->string('pm_address_is')->nullable();
            $table->string('sup_name_is')->nullable();
            $table->string('sup_address_is')->nullable();
            $table->string('adj_name_is')->nullable();
            $table->string('adj_address_is')->nullable();
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
            $table->dropColumn('works_are');
            $table->dropColumn('employer_name_is');
            $table->dropColumn('employer_address_is');
            $table->dropColumn('pm_name_is');
            $table->dropColumn('pm_address_is');
            $table->dropColumn('sup_name_is');
            $table->dropColumn('sup_address_is');
            $table->dropColumn('adj_name_is');
            $table->dropColumn('adj_address_is');
        });
    }
}

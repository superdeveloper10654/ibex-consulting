<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {

            //step 3
            $table->string('employer_name_is');
            $table->string('employer_address_is');
            $table->dropForeign('contract_applications_employer_or_client_id_foreign');
            $table->dropColumn('employer_or_client_id');
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
            $table->dropColumn('employer_name_is');
            $table->dropColumn('employer_address_is');
            $table->bigInteger('employer_or_client_id')->unsigned()->before('created_at')->nullable();
            $table->foreign('employer_or_client_id')->references('id')->on('profiles');
        });
    }
}

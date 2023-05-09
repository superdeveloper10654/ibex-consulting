<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtColumnToContractPartTwoRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('part_two_nec4_contract_datas', function (Blueprint $table) {
            $table->softDeletes()->after('created_at');
        });

        Schema::table('contract_key_peoples', function (Blueprint $table) {
            $table->softDeletes()->after('created_at');
        });

        Schema::table('contract_defined_costs', function (Blueprint $table) {
            $table->softDeletes()->after('created_at');
        });

        Schema::table('contract_shared_service_defined_costs', function (Blueprint $table) {
            $table->softDeletes()->after('created_at');
        });

        Schema::table('contract_size_base_equipments', function (Blueprint $table) {
            $table->softDeletes()->after('created_at');
        });

        Schema::table('contract_time_base_equipments', function (Blueprint $table) {
            $table->softDeletes()->after('created_at');
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
        });
    }
}

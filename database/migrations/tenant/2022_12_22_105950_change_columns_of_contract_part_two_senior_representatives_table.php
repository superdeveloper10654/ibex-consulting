<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsOfContractPartTwoSeniorRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_part_two_senior_representatives', function (Blueprint $table) {
            $table->bigInteger('profile_id')->before('created_at')->unsigned();
            $table->foreign('profile_id')->references('id')->on('profiles');

            $table->dropColumn('name');
            $table->dropColumn('address');
            $table->dropColumn('elect_address');
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
            $table->dropColumn('profile_id');

            $table->string('name');
            $table->text('address');
            $table->text('elect_address');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProviderToAdditionalEmployerRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('additional_employer_risks', function (Blueprint $table) {
            $table->string('provider')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('additional_employer_risks', function (Blueprint $table) {
            if (Schema::hasColumn('additional_employer_risks', 'provider')) {
                $table->dropColumn('provider');
            }
        });
    }
}

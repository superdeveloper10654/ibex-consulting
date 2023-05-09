<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('early_warnings', function (Blueprint $table) {
            $table->tinyInteger('risk_score')->comment('risk Score')->after('effect4')->default(0);
            $table->tinyInteger('score_order')->comment('risk Score Order')->after('risk_score')->default(0);


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('early_warnings', function(Blueprint $table) {
            $table->dropColumn('risk_score');
            $table->dropColumn('score_order');
        });
    }
}

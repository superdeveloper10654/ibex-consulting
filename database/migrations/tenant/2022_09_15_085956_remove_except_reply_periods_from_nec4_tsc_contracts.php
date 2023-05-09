<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveExceptReplyPeriodsFromNec4TscContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nec4_tsc_contracts', function (Blueprint $table) {
            $table->dropColumn('except_period_for_reply_for_1');
            $table->dropColumn('except_period_for_reply_is_1');
            $table->dropColumn('except_period_for_reply_for_2');
            $table->dropColumn('except_period_for_reply_is_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nec4_tsc_contracts', function (Blueprint $table) {
            $table->string('except_period_for_reply_for_1')->nullable();
            $table->string('except_period_for_reply_is_1')->nullable();
            $table->string('except_period_for_reply_for_2')->nullable();
            $table->string('except_period_for_reply_is_2')->nullable();
        });
    }
}

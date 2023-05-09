<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToExceptReplyPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('except_reply_periods', function (Blueprint $table) {
            $table->boolean('is_by_sub_contractor')->before('created_at')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('except_reply_periods', function (Blueprint $table) {
            if (Schema::hasColumn('except_reply_periods', 'is_by_sub_contractor')) {
                $table->dropColumn('is_by_sub_contractor');
            }
            if (Schema::hasColumn('except_reply_periods', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
}

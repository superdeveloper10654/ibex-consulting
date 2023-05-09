<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTaskOrdersField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measures', function(Blueprint $table) {
            $table->dropColumn('task_order_id');
        });
        Schema::table('applications', function(Blueprint $table) {
            $table->dropColumn('task_order_id');
        });
        Schema::drop('task_orders');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

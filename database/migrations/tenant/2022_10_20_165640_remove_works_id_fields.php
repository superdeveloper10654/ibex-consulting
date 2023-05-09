<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveWorksIdFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instructions', function(Blueprint $table) {
            $table->dropColumn('works_id');
        });
        Schema::table('invoices', function(Blueprint $table) {
            $table->dropColumn('works_id');
        });
        Schema::table('tasks', function(Blueprint $table) {
            $table->dropColumn('works_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instructions', function(Blueprint $table) {
            $table->integer('works_id');
        });
        Schema::table('invoices', function(Blueprint $table) {
            $table->integer('works_id');
        });
        Schema::table('tasks', function(Blueprint $table) {
            $table->integer('works_id');
        });
    }
}

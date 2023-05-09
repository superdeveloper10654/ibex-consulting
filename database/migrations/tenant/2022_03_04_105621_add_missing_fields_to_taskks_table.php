<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToTaskksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('taskks', 'deadline')) {
            Schema::table('taskks', function (Blueprint $table) {
                $table->dateTime('deadline')->default(now());
            });
        }
        if (!Schema::hasColumn('taskks', 'planned_start')) {
            Schema::table('taskks', function (Blueprint $table) {
                $table->dateTime('planned_start')->default(now());
            });
        }
        if (!Schema::hasColumn('taskks', 'planned_end')) {
            Schema::table('taskks', function (Blueprint $table) {
                $table->dateTime('planned_end')->default(now());
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taskks', function (Blueprint $table) {
            $table->dropColumn('deadline');
            $table->dropColumn('planned_start');
            $table->dropColumn('planned_end');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToTaskkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('taskks', 'type')) {
            Schema::table('taskks', function (Blueprint $table) {
                $table->string('type')->nullable();
            });
        }
        if (!Schema::hasColumn('taskks', 'owner_id')) {
            Schema::table('taskks', function (Blueprint $table) {
                $table->integer('owner_id')->nullable();
            });
        }
        if (!Schema::hasColumn('taskks', 'priority')) {
            Schema::table('taskks', function (Blueprint $table) {
                $table->string('priority')->nullable();
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
            $table->dropColumn('type');
            $table->dropColumn('owner_id');
            $table->dropColumn('priority');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnnecessaryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('early_warning_comments')) {
            Schema::drop('early_warning_comments');
        }

        if (Schema::hasTable('instruction_comments')) {
            Schema::drop('instruction_comments');
        }

        if (Schema::hasTable('quote_comments')) {
            Schema::drop('quote_comments');
        }
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

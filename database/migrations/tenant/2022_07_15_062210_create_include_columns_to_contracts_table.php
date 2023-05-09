<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncludeColumnsToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('contracts', function (Blueprint $table) {
                $table->bigInteger('profile_id')->nullable()->unsigned();
                $table->foreign('profile_id')->references('id')->on('profiles');
                $table->decimal('latitude', 20, 16);
                $table->decimal('longitude', 20, 16);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function(Blueprint $table) {
            $table->dropColumn('profile_id');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}

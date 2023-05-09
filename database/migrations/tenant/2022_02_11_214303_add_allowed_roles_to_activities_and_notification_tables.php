<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowedRolesToActivitiesAndNotificationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity', function (Blueprint $table) {
            $table->integer('allowed_roles')
                ->nullable()
                ->after('img');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->integer('allowed_roles')
                ->nullable()
                ->after('img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity', function (Blueprint $table) {
            $table->dropColumn('allowed_roles');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('allowed_roles');
        });
    }
}

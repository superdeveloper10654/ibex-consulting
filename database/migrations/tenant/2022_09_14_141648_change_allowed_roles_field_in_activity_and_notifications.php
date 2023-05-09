<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAllowedRolesFieldInActivityAndNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity', function (Blueprint $table) {
            $table->dropColumn('allowed_roles');
        });
        Schema::table('activity', function (Blueprint $table) {
            $table->addColumn('json', 'allowed_roles', [
                'after'     => 'img',
                'nullable'  => true,
            ]);
            $table->addColumn('integer', 'allowed_department', [
                'after'     => 'allowed_roles',
                'nullable'  => true,
            ]);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['allowed_roles']);
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->addColumn('json', 'allowed_roles', [
                'after'     => 'img',
                'nullable'  => true,
            ]);
            $table->addColumn('integer', 'allowed_department', [
                'after'     => 'allowed_roles',
                'nullable'  => true,
            ]);
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
            $table->dropColumn(['allowed_roles', 'allowed_department']);
            $table->addColumn('integer', 'allowed_roles', [
                'after'     => 'img',
                'nullable'  => true,
            ]);
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['allowed_roles', 'allowed_department']);
            $table->addColumn('integer', 'allowed_roles', [
                'after'     => 'img',
                'nullable'  => true,
            ]);
        });
    }
}

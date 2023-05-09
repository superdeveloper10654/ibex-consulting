<?php

use AppTenant\Models\Statical\Department;
use AppTenant\Models\Profile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeProfilesTableToCorrespondDepartmentModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('department');
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->integer('department')->comment('Model Department')->after('password');
        });

        DB::query("UPDATE profiles SET department = 1 WHERE id IS NOT NULL"); // Department::COMMERCIAL_ID
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('department');
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->string('department')->after('password');
        });

        DB::query("UPDATE profiles SET department = 'Commercial' WHERE id IS NOT NULL"); // Department::COMMERCIAL
    }
}

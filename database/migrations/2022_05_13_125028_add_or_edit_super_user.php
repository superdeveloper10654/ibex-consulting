<?php

use AppTenant\Models\Profile;
use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddOrEditSuperUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $profile = DB::selectOne("SELECT * FROM profiles WHERE email = ?", ['support@ibex-consulting.co.uk']);

        if (empty($profile)) {
            DB::insert("INSERT INTO profiles 
                (first_name, last_name, email, password, role, department, avatar, dob, email_verified_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ", [
                'Ibex',
                'Support',
                'support@ibex-consulting.co.uk',
                '$2y$10$1Z0YRvS9ebcC01BWoI1tR.KyKjbxrNDnTXavPOsLxF0/wfNzBHmUy',
                1, // Role::SUPER_ADMIN_ID,
                1, // Department::COMMERCIAL_ID,
                '/assets/images/svg/help-support.svg',
                '2000-01-01',
                date('Y-m-d'),
            ]);
        } else {
            DB::update("UPDATE profiles SET role = 1 WHERE id = ?", [$profile->id]); // Role::SUPER_ADMIN_ID
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

<?php

namespace Database\Seeders;

use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\Role;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AddProfilesTeam extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $email = 'tests.admin@tests.tests';

        DB::table('profiles')->insertGetId([
            'first_name'    => $faker->firstName(),
            'last_name'     => $faker->lastName(),
            'email'         => $email,
            'organisation'  => 'Ibex Testers LTD',
            'department'    => Department::COMMERCIAL_ID,
            'role'          => Role::ADMIN_ID,
            'password'      => Hash::make('das4jvDas_8va3jVhd'),
            'avatar'        => '/assets/images/svg/help-support.svg',
            'created_at'    => Date::now(),
            'updated_at'    => Date::now(),
        ]);
        $this->command->info('Admin: ' . $email);

        $email = 'tests.contractor@tests.tests';

        DB::table('profiles')->insert([
            'first_name'        => $faker->firstName(),
            'last_name'         => $faker->lastName(),
            'email'             => $email,
            'organisation'      => 'Ibex Testers LTD',
            'department'        => Department::COMMERCIAL_ID,
            'role'              => Role::CONTRACTOR_ID,
            'password'          => Hash::make('das4jvDas_8va3jVhd'),
            'avatar'            => '/assets/images/svg/help-support.svg',
            'created_at'        => Date::now(),
            'updated_at'        => Date::now(),
        ]);
        $this->command->info('Contractor: ' . $email);

        $email = 'tests.employer@tests.tests';

        DB::table('profiles')->insert([
            'first_name'        => $faker->firstName(),
            'last_name'         => $faker->lastName(),
            'email'             => $email,
            'organisation'      => 'Ibex Testers LTD',
            'department'        => Department::COMMERCIAL_ID,
            'role'              => Role::PROJECT_MANAGER_ID,
            'password'          => Hash::make('das4jvDas_8va3jVhd'),
            'avatar'            => '/assets/images/svg/help-support.svg',
            'created_at'        => Date::now(),
            'updated_at'        => Date::now(),
        ]);
        $this->command->info('Employer: ' . $email);
    }
}

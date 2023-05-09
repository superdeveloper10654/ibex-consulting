<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            [
                'first_name'=>'admin',
                'last_name'=>'admin',
                'email'=>'admin@admin.com',
                'password'=>bcrypt('password'),
                'phone'  => '1103937482',
                // 'dob'  => '1996-02-18',
                'avatar'  => '',
                'department'  => '1',
                'organisation'  => '1',
                'role'  => '1',
                'team_users_count'=> 2
            ]
        ]);
    }
}

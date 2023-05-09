<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InitialProject::class);
        $this->call(TasksTableSeeder::class);
        $this->call(LinksTableSeeder::class);
        $this->call(ProfileTableSeeder::class);
        $this->call(ApprovalStatusesTableSeeder::class);
    }
}

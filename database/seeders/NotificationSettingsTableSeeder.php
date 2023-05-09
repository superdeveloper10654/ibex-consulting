<?php

namespace Database\Seeders;

use AppTenant\Models\NotificationSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NotificationSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $items = [

            [
                'name' => 'MS Teams Early Warnings Notifications Webhook URL',
                'description' => 'MS Teams Webhook URL for receiving Early Warning Notifications',
            ],
            [
                'name' => 'MS Teams Applications Notifications Webhook URL',
                'description' => 'MS Teams Webhook URL for receiving Applications Notifications',
            ]
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($items as $item) {
            $setting = NotificationSetting::where('slug', '=', Str::slug($item['name']))->first();
            if ($setting === null) {
                NotificationSetting::create([
                    'name'          => $item['name'],
                    'description'   => $item['description'],
                    'slug'          => Str::slug($item['name']),
                ]);
            }
        }
    }
}

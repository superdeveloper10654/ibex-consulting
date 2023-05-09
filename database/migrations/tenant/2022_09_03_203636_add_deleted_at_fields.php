<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = [
            'activity_schedules',
            'all_tasks',
            'applications',
            'assessments',
            'boq_schedules',
            'calendars',
            'comments',
            'contracts',
            'daily_direct_personnels',
            'daily_direct_vehicles_and_plants',
            'daily_operational_timing_operations',
            'daily_operational_timing_plant_haulages',
            'daily_operational_timing_supplied_materials',
            'daily_operational_timing_to_client_infos',
            'daily_ordered_supplied_materials',
            'daily_site_risks',
            'daily_subcontract_personnels',
            'daily_sub_contract_client_operations',
            'daily_sub_contract_or_hired_vehicles_and_plants',
            'daily_weather_conditions',
            'daily_work_records',
            'direct_personnel',
            'direct_vehicles_and_plants',
            'early_warnings',
            'early_warning_comments',
            'gantt_columns',
            'gantt_task_assignees',
            'gantt_task_process',
            'instructions',
            'instruction_comments',
            'invoices',
            'links',
            'materials',
            'measures',
            'media',
            'MMB_tasks',
            'notifications',
            'operations',
            'part_two_contract_datas',
            'payments',
            'price_lists',
            'profiles',
            'profile_folders',
            'programmes',
            'quotes',
            'quote_comments',
            'rate_cards',
            'receipts',
            'subcontract_or_client_operations',
            'subcontract_or_hired_vehicles_and_plants',
            'subcontract_personnel',
            'subscriptions',
            'subscription_items',
            'taskks',
            'taskks_back',
            'taskks_back_multi',
            'tasks',
            'tax_rates',
            'tsc_contracts',
            'uploads',
            'user_programme_links',
            'works',
        ];

        foreach ($tables as $table_name) {
            Schema::table($table_name, function(Blueprint $table) {
                $table->softDeletes()
                    ->after('updated_at');
            });
        }


        $tables = [
            'activity',
        ];

        foreach ($tables as $table_name) {
            Schema::table($table_name, function(Blueprint $table) {
                $table->softDeletes();
            });
        }


        $tables = [
            'gantt_tasks',
            'gantt_programmes',
            'gantt_versions',
            'resources',
        ];

        foreach ($tables as $table_name) {
            Schema::table($table_name, function(Blueprint $table) {
                $table->softDeletes();
            });
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

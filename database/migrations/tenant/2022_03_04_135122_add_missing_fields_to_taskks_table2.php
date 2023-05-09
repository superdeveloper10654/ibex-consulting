<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToTaskksTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('taskks', 'open')) {
            Schema::table('taskks', function (Blueprint $table) {
                $table->integer('open')->nullable()->default(NULL);
            });
        }

        if (!Schema::hasTable('taskks_back')) {
            DB::statement('CREATE TABLE `taskks_back` (
                `id` int(10) UNSIGNED NOT NULL,
                `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `duration` int(11) NOT NULL,
                `progress` double(8,2) NOT NULL,
                `start_date` datetime NOT NULL,
                `parent` int(11) NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                `sortorder` int(11) NOT NULL DEFAULT 0
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        }

        if (!Schema::hasTable('taskks_back_multi')) {
            DB::statement('CREATE TABLE `taskks_back_multi` (
                `id` int(10) UNSIGNED NOT NULL,
                `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `duration` int(11) NOT NULL,
                `progress` double(8,2) NOT NULL,
                `start_date` datetime NOT NULL,
                `parent` int(11) NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                `sortorder` int(11) NOT NULL DEFAULT 0,
                `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `owner_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `priority` int(11) DEFAULT NULL,
                `level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `project_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `open` int(11) DEFAULT NULL,
                `end_date` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taskks', function (Blueprint $table) {
            $table->dropColumn('open');
        });

        Schema::dropIfExists('taskks_back');
        Schema::dropIfExists('taskks_back_multi');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity', function (Blueprint $table) {
            $table->string('resource', 255)
                ->after('link')
                ->nullable();
            $table->unsignedInteger('resource_id')
                ->after('resource')
                ->nullable();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->string('resource', 255)
                ->after('link')
                ->nullable();
            $table->unsignedInteger('resource_id')
                ->after('resource')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity', function (Blueprint $table) {
            $table->dropColumn(['resource', 'resource_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['resource', 'resource_id']);
        });
    }
};

<?php

use AppTenant\Models\Profile;
use AppTenant\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profiles', function(Blueprint $table) {
            $table->uuid('uuid')
                ->after('parent_id');
        });

        Profile::all()->map(function($profile) {
            $profile->uuid = Str::uuid()->toString();
            $profile->update();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function(Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};

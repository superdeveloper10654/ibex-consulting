<?php

use AppTenant\Models\Status\ProgrammeStatus;
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
        Schema::table('programmes', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')
                ->after('identifier')
                ->default(ProgrammeStatus::SUBMITTED_ID);
            $table->dateTime ('accepted_at')
                ->after('active')
                ->nullable();
            $table->renameColumn('account_id', 'created_by');
            $table->dropColumn(['parent_id', 'identifier', 'default_project_guid', 'last_save_time', 'last_save_author_id', 'current_version_id', 'created', 'current_snapshot', 'undo_redo_version_id', 'active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropColumn(['status', 'accepted_at']);
            $table->renameColumn('created_by', 'account_id');
            $table->integer('parent_id')->default(0);
            $table->string('identifier', 255)->nullable();
            $table->string('default_project_guid', 512)->nullable();
            $table->integer('last_save_time')->nullable();
            $table->integer('last_save_author_id')->nullable();
            $table->integer('created');
            $table->integer('current_snapshot')->default(0);
            $table->integer('current_version_id')->nullable();
            $table->integer('undo_redo_version_id')->nullable();
            $table->integer('active')->default(1);
        });
    }
};

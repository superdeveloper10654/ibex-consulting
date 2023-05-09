<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingDbTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function(Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('programme_id', 255)->nullable();
            $table->integer('parent_id');
            $table->integer('calendar_id')->nullable();
            $table->integer('active')->default(1);
        });
      
        Schema::create('gantt_programmes', function(Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->string('name', 255);
            $table->integer('parent_id')->default(0);
            $table->string('identifier', 255)->nullable();
            $table->string('sharing_identifier', 512);
            $table->string('default_project_guid', 512)->nullable();
            $table->integer('last_save_time')->nullable();
            $table->integer('last_save_author_id')->nullable();
            $table->integer('created');
            $table->integer('current_snapshot')->default(0);
            $table->integer('current_version_id')->nullable();
            $table->integer('undo_redo_version_id')->nullable();
            $table->integer('active')->default(1);
        });
      
        Schema::create('gantt_tasks', function(Blueprint $table) {
            $table->id();
            $table->string('guid', 255)->nullable();
            $table->integer('parent')->nullable();
            $table->string('programme_id', 255)->nullable();
            $table->string('text', 255)->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('position', 1)->nullable();
            $table->string('baseline_start', 255)->nullable();
            $table->string('baseline_end', 255)->nullable();
            $table->string('baseline_progress', 255)->nullable();
            $table->string('deadline', 255)->nullable();
            $table->string('duration', 11)->nullable();
            $table->integer('duration_unit')->default(0);
            $table->integer('duration_hours')->nullable();
            $table->integer('duration_worked')->nullable();
            $table->integer('opened')->default(1);
            $table->float('progress', 12, 0)->nullable()->default(0);
            $table->integer('sortorder')->default(0);
            $table->integer('calendar_id')->nullable()->default(0);
            $table->string('type', 255)->nullable()->default('task');
            $table->string('resource_id', 255)->nullable();
            $table->integer('active')->default(1);
            $table->integer('status')->nullable()->default(1);
            $table->string('workload_quantity', 255)->nullable();
            $table->string('workload_quantity_unit', 255)->nullable();
            $table->integer('resource_group_id')->nullable()->default(0);
            $table->integer('order_ui')->nullable();
            $table->text('comment')->nullable();
            $table->integer('is_summary')->default(0);
            $table->integer('pending_deletion')->default(0);
            $table->integer('constraint_type')->default(0);
            $table->string('color', 20)->default('#299cb4');
        });
      
        Schema::create('gantt_versions', function(Blueprint $table) {
            $table->id();
            $table->string('guid', 255)->nullable();
            $table->integer('programme_id');
            $table->longtext('gantt_data')->nullable();
            $table->longtext('aux_data')->nullable();
            $table->integer('user_id');
            $table->integer('created');
            $table->string('action', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('description_2', 255)->nullable();
            $table->string('primary_object_guid', 255)->nullable();
            $table->string('secondary_object_guid', 255)->nullable();
            $table->integer('active')->default(1);
            $table->integer('is_reference_version')->default(0);
            $table->text('ui_string')->nullable();
            $table->integer('to_finalise')->nullable()->default(0);
            $table->integer('pending')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
        Schema::dropIfExists('gantt_programmes');
        Schema::dropIfExists('gantt_tasks');
        Schema::dropIfExists('gantt_versions');
    }
}

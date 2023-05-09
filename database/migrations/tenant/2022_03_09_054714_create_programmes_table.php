<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgrammesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->string('name');
            $table->integer('parent_id')->nullable();
            $table->string('identifier')->nullable();
            $table->string('sharing_identifier')->nullable();
            $table->string('default_project_guid')->nullable();
            $table->integer('last_save_time')->nullable();
            $table->integer('last_save_author_id')->nullable();
            $table->integer('created')->nullable();
            $table->integer('current_snapshot')->default(0);
            $table->integer('current_version_id')->nullable();
            $table->integer('undo_redo_version_id')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programmes');
    }
}

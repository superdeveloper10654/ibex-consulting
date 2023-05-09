<?php

use AppTenant\Models\Profile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('profile_folders')) {
            Schema::create('profile_folders', function (Blueprint $table) {
                $table->id();
                $table->integer('profile_id');
                $table->string('folder_name');
                $table->unique(['profile_id', 'folder_name']);
                $table->timestamps();
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
        Schema::dropIfExists('profile_folders');
    }
}

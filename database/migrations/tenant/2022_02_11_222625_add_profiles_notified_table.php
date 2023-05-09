<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilesNotifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_notified', function (Blueprint $table) {
            $table->integer('profile_id');
            $table->integer('notification_id');
            $table->timestamp('created_at');

            $table->index(['profile_id', 'notification_id']);
            $table->unique(['profile_id', 'notification_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profiles_notified');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitialProjectTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function(Blueprint $table) {
            $table->id();
            $table->integer('profile_id');
            $table->text('text');
            $table->text('img');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('notifications', function(Blueprint $table) {
            $table->id();
            $table->integer('profile_id');
            $table->text('text');
            $table->text('img');
            $table->timestamps();
        });

        Schema::rename('users', 'profiles');
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->after('id');
            $table->string('last_name')
                ->nullable()
                ->after('first_name');
            $table->string('department')
                ->nullable()
                ->after('password');
            $table->string('organisation')
                ->nullable()
                ->after('department');
            $table->string('phone')
                ->nullable()
                ->after('organisation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::dropIfExists('activity');
        Schema::dropIfExists('notifications');

        Schema::rename('profiles', 'users');
        Schema::table('users', function(Blueprint $table) {
            $table->string('name');
            $table->dropColumn(['first_name', 'last_name', 'department', 'organisation', 'phone']);
        });
    }
}

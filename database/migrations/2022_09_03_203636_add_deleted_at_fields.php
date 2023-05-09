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
        Schema::table('activity', function(Blueprint $table) {
            $table->softDeletes()
                ->after('created_at');
        });
        Schema::table('domains', function(Blueprint $table) {
            $table->softDeletes()
                ->after('updated_at');
        });
        Schema::table('notifications', function(Blueprint $table) {
            $table->softDeletes()
                ->after('updated_at');
        });
        Schema::table('profiles', function(Blueprint $table) {
            $table->softDeletes()
                ->after('updated_at');
        });
        Schema::table('receipts', function(Blueprint $table) {
            $table->softDeletes()
                ->after('updated_at');
        });
        Schema::table('subscriptions', function(Blueprint $table) {
            $table->softDeletes()
                ->after('updated_at');
        });
        Schema::table('subscription_items', function(Blueprint $table) {
            $table->softDeletes()
                ->after('updated_at');
        });
        Schema::table('tax_rates', function(Blueprint $table) {
            $table->softDeletes()
                ->after('updated_at');
        });
        Schema::table('tenants', function(Blueprint $table) {
            $table->softDeletes()
                ->after('updated_at');
        });
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

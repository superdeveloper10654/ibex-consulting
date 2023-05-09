<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyWorkRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_work_records', function (Blueprint $table) {
            $table->id();
            $table->text('contract_or_wbs_no')->nullable();
            $table->text('client_name')->nullable();
            $table->text('reference_no')->nullable();
            $table->text('crew_name')->nullable();
            $table->text('date')->nullable();
            $table->text('site_name')->nullable();
            $table->text('supervisor')->nullable();
            $table->text('foreman')->nullable();
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
        Schema::dropIfExists('daily_work_records');
    }
}

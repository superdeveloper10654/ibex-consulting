<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyOperationalTimingToClientInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_operational_timing_to_client_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('daily_work_record_id')->unsigned();
            $table->foreign('daily_work_record_id','dwr_dotci_id')->references('id')->on('daily_work_records');
            $table->text('demoblished_or_offsite')->nullable();
            $table->text('informed_client')->nullable();
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('daily_operational_timing_to_client_infos');
    }
}

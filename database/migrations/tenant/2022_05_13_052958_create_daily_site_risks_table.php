<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySiteRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_site_risks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('daily_work_record_id')->unsigned();
            $table->foreign('daily_work_record_id','dwr_dsr_id')->references('id')->on('daily_work_records');
            $table->text('description_of_issue')->nullable();
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
        Schema::dropIfExists('daily_site_risks');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyOrderedSuppliedMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_ordered_supplied_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('daily_work_record_id')->unsigned();
            $table->foreign('daily_work_record_id','dwr_dosm_id')->references('id')->on('daily_work_records');
            $table->bigInteger('material_id')->unsigned();
            $table->foreign('material_id','mat_dosm_id')->references('id')->on('materials');
            $table->text('prog')->nullable();
            $table->text('on_site')->nullable();
            $table->text('supplied')->nullable();
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
        Schema::dropIfExists('daily_ordered_supplied_materials');
    }
}

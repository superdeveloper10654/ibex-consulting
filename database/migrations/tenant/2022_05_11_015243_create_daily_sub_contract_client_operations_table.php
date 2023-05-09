<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySubContractClientOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_sub_contract_client_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('daily_work_record_id')->unsigned();
            $table->foreign('daily_work_record_id','dwr_id')->references('id')->on('daily_work_records');
            $table->bigInteger('subcontract_or_client_operation_id')->unsigned();
            $table->foreign('subcontract_or_client_operation_id','sco_id')->references('id')->on('subcontract_or_client_operations');
            $table->bigInteger('operation_id')->unsigned();
            $table->foreign('operation_id')->references('id')->on('operations');
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
        Schema::dropIfExists('daily_sub_contract_client_operations');
    }
}

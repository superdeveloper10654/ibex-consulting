<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('main_opt')->nullable();
            $table->string('resolution_opt')->nullable();
            $table->boolean('sec_opt_X1')->default(0);
            $table->boolean('sec_opt_X2')->default(0);
            $table->boolean('sec_opt_X3')->default(0);
            $table->boolean('sec_opt_X4')->default(0);
            $table->boolean('sec_opt_X5')->default(0);
            $table->boolean('sec_opt_X6')->default(0);
            $table->boolean('sec_opt_X7')->default(0);
            $table->boolean('sec_opt_X8')->default(0);
            $table->boolean('sec_opt_X9')->default(0);
            $table->boolean('sec_opt_X10')->default(0);
            $table->boolean('sec_opt_X11')->default(0);
            $table->boolean('sec_opt_X12')->default(0);
            $table->boolean('sec_opt_X13')->default(0);
            $table->boolean('sec_opt_X14')->default(0);
            $table->boolean('sec_opt_X15')->default(0);
            $table->boolean('sec_opt_X16')->default(0);
            $table->boolean('sec_opt_X17')->default(0);
            $table->boolean('sec_opt_X18')->default(0);
            $table->boolean('sec_opt_X19')->default(0);
            $table->boolean('sec_opt_X20')->default(0);
            $table->boolean('sec_opt_yUK1')->default(0);
            $table->boolean('sec_opt_yUK2')->default(0);
            $table->boolean('sec_opt_yUK3')->default(0);
            $table->boolean('sec_opt_Z1')->default(0);
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
        Schema::dropIfExists('contract_applications');
    }
}

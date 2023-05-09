<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskmanagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riskmanagement', function (Blueprint $table) {
            $table->id()
                ->autoIncrement();
            $table->integer('profile_id')->nullable();
            $table->integer("contract_id")
                ->nullable();
            // rist_type = 0:probabilty,1:impact,2:severity
            $table->integer('risk_type');
            $table->string('probability');
            $table->integer('from');
            $table->integer('to');
            $table->integer('score');
            $table->string('impact');
            $table->string('color');
            $table->string('severity');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riskmanagement');
    }
}

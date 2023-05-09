<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuotationsAddAssessmentAndInstructionFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->removeColumn('early_warning_id');
            $table->integer('assessment_id')
                ->nullable()
                ->after('programme_id');
            $table->integer('instruction_id')
                ->nullable()
                ->after('assessment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->removeColumn(['assessment_id', 'instruction_id']);
            $table->integer('early_warning_id')
                ->nullable()
                ->after('programme_id');
        });
    }
}

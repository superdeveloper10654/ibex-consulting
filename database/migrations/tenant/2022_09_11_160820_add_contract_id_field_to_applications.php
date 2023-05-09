<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractIdFieldToApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->addColumn('integer', 'contract_id', [
                'after' => 'payment_id',
            ]);
            $table->addColumn('integer', 'measure_id', [
                'after' => 'contract_id',
            ]);
            $table->dropColumn(['works_id', 'assessment_id', 'payment_id']);
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->addColumn('integer', 'application_id', [
                'nullable'  => true,
                'after'     => 'contract_id',
            ]);
            $table->addColumn('integer', 'certified_by', [
                'after'     => 'status',
                'nullable'  => true,
            ]);
            $table->addColumn('datetime', 'certified_at', [
                'after'     => 'certified_by',
                'nullable'  => true,
            ]);
            $table->dropColumn(['works_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->addColumn('integer', 'assessment_id', [
                'after' => 'contract_id',
            ]);
            $table->dropColumn(['works_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->addColumn('integer', 'works_id', [
                'after' => 'id',
            ]);
            $table->addColumn('integer', 'assessment_id', [
                'after' => 'works_id',
            ]);
            $table->addColumn('integer', 'payment_id', [
                'after' => 'assessment_id',
            ]);
            $table->dropColumn(['contract_id', 'measure_id']);
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->addColumn('integer', 'works_id', [
                'after' => 'period_to',
            ]);
            $table->dropColumn(['application_id', 'certified_by', 'certified_at']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->addColumn('integer', 'works_id', [
                'after' => 'contract_id',
            ]);
            $table->dropColumn(['assessment_id']);
        });
    }
}
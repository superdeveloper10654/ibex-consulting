<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeCategoryFieldTypeInWorkflows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update('UPDATE workflows SET category = ?', [1]);
        
        Schema::table('workflows', function (Blueprint $table) {
            $table->integer('category')
                ->comment('WorkflowCategory Model')
                ->change();
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
        Schema::table('workflows', function (Blueprint $table) {
            $table->string('category')->change();
            $table->dropSoftDeletes();
        });
    }
}

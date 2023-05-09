<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('programme_id');
            $table->integer('early_warning_id')
                ->nullable();
            $table->integer('contract_date_effect')
                ->comment('+/- days');
            $table->integer('contract_key_date_1_effect')
                ->comment('+/- days');
            $table->integer('contract_key_date_2_effect')
                ->comment('+/- days');
            $table->integer('contract_key_date_3_effect')
                ->comment('+/- days');
            $table->decimal('price_effect', 10, 2)
                ->comment('+/- £');
            $table->integer('status');
            $table->integer('created_by');
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
        Schema::dropIfExists('quotations');
    }
}

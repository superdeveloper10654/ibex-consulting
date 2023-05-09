<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompensationEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compensation_events', function (Blueprint $table) {
            $table->id();
            $table->integer('programme_id');
            $table->string('title');
            $table->text('description');
            $table->boolean('early_warning_notified')
                ->default(0);
            $table->boolean('early_warning_id')
                ->nullable();
            $table->smallInteger('status')
                ->comment('CompensationEventStatus model');
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
        Schema::dropIfExists('compensation_events');
    }
}

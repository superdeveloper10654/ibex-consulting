<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProgrammeLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_programme_links', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('programme_id')->nullable();
            $table->integer('permission_type')->default(1);
            $table->date('date_range_start')->nullable();
            $table->date('date_range_end')->nullable();
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
        Schema::dropIfExists('user_programme_links');
    }
}

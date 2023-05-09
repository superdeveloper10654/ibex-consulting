<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStep7FieldsToContractApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            // step7
            $table->text('weather_recording_place_is')->nullable();
            $table->text('weather_recording_snow_hour')->nullable();
            $table->text('weather_recording_additional')->nullable();
            $table->text('weather_recording_supplier')->nullable();
            $table->text('weather_data_recorded_at')->nullable();
            $table->text('weather_data_available_from')->nullable();
            $table->text('weather_data_assumed')->nullable();
            $table->text('insurance_text_1')->nullable();
            $table->text('insurance_min_text_2')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_applications', function (Blueprint $table) {
            $table->dropColumn('weather_recording_place_is');
            $table->dropColumn('weather_recording_snow_hour');
            $table->dropColumn('weather_recording_additional');
            $table->dropColumn('weather_recording_supplier');
            $table->dropColumn('weather_data_recorded_at');
            $table->dropColumn('weather_data_available_from');
            $table->dropColumn('weather_data_assumed');
            $table->dropColumn('insurance_text_1');
            $table->dropColumn('insurance_min_text_2');
        });
    }
}

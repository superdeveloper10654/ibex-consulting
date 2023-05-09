<?php

use AppTenant\Models\Statical\RateCardUnit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CreateRateCardPinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_card_pins', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                ->default('Default');
            $table->integer('rate_card_unit')
                ->comment('RateCardUnit model');
            $table->string('icon')
                ->nullable();
            $table->string('line_color')
                ->nullable();
            $table->string('line_type')
                ->nullable();
            $table->string('fill_color')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $rate_cards = DB::select('SELECT * FROM rate_cards');
        $created_pins = [];
        
        foreach ($rate_cards as $rate_card) {
            $created_pin_id = array_search($rate_card->pin, $created_pins);

            if (!empty($created_pin_id)) {
                $rate_card->pin_id = $created_pin_id;
                continue;
            }

            if ($rate_card->unit == RateCardUnit::ITEM_ID) {
                $file_name = md5(microtime()) . '.svg';
                $file_path = config('path.images.rate_cards.pins') . "/$file_name";
                $existing_file = File::get(public_path('assets/images/pins/pin-1.svg'));
                Storage::disk('public')->put($file_path, $existing_file);

                $new_pin = [
                    'icon'              => $file_name,
                    'line_color'        => null,
                    'line_type'         => null,
                    'fill_color'        => null,
                ];

            } else if ($rate_card->unit == RateCardUnit::LINE_ID) {
                $line_arr = explode('-', $rate_card->pin);
                $new_pin = [
                    'icon'              => null,
                    'line_color'        => $line_arr[0],
                    'line_type'         => $line_arr[1],
                    'fill_color'        => null,
                ];

            } else {
                $new_pin = [
                    'icon'              => null,
                    'line_color'        => null,
                    'line_type'         => null,
                    'fill_color'        => $rate_card->pin,
                ];
            }

            $new_pin['rate_card_unit'] = $rate_card->unit;
            $date_time = date('Y-m-d H:i:s');
            DB::insert("INSERT INTO rate_card_pins 
                (rate_card_unit, icon, line_color, line_type, fill_color, created_at, updated_at) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?)
            ", [
                $new_pin['rate_card_unit'], 
                $new_pin['icon'],
                $new_pin['line_color'],
                $new_pin['line_type'],
                $new_pin['fill_color'],
                $date_time,
                $date_time
            ]);
            $created_pin_id = DB::getPdo()->lastInsertId();
            $rate_card->pin_id = $created_pin_id;
            $created_pins[$created_pin_id] = $rate_card->pin;
        }

        Schema::table('rate_cards', function(Blueprint $table) {
            $table->dropColumn('pin');
            $table->integer('pin_id')
                ->after('rate');
        });

        foreach ($rate_cards as $rate_card) {
            DB::update('UPDATE rate_cards SET pin_id = ? WHERE id = ?', [$rate_card->pin_id, $rate_card->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_card_pins');
        Schema::table('rate_cards', function(Blueprint $table) {
            $table->dropColumn('pin_id');
            $table->string('pin')
                ->after('rate')
                ->default(1);
        });
    }
}

<?php

namespace Database\Seeders;

use AppTenant\Models\Statical\RateCardUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialProject extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contract_id = DB::table('contracts')->insertGetId([
            'contractor_name'   => 'MMB Networks Ltd',
            'order_ref'         => '',
            'contract_type'     =>'ECC',
            'contract_name'     => 'FTTH Isle of Wight',
            'kml_filepath'      => '',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'latitude'          => 0.00144088,
            'longitude'         => -0.00043479
        ]);

        $works_civils_id = DB::selectOne("SELECT id FROM works WHERE name = 'Civils'")->id;
        $works_cabling_id = DB::selectOne("SELECT id FROM works WHERE name = 'Cabling'")->id;

        $rate_cards = [
            [
                'works_id'      => $works_civils_id,
                'ref'           => '1001',
                'item_desc'     => '1001 | Verge | Type FW2; preformed (Stakkabox)',
                'unit'          => RateCardUnit::ITEM_ID,
                'rate'          => 360,
                'pin'           => '1'
            ],
            [
                'works_id'      => $works_civils_id,
                'ref'           => '1031',
                'item_desc'     => '1031 | Footway | FTTH Toby Box; Tarmac',
                'unit'          => RateCardUnit::ITEM_ID,
                'rate'          => 55,
                'pin'           => '1'
            ],
            [
                'works_id'      => $works_cabling_id,
                'ref'           => '1040',
                'item_desc'     => '1040 | Fibre Cabinet Installation | Active Cabinet',
                'unit'          => RateCardUnit::ITEM_ID,
                'rate'          => 60,
                'pin'           => '3'
            ],
            [
                'works_id'      => $works_cabling_id,
                'ref'           => '1041',
                'item_desc'     => '1041 | Fibre Cabinet Installation | FDP',
                'unit'          => RateCardUnit::ITEM_ID,
                'rate'          => 75,
                'pin'           => '3'
            ],
            [
                'works_id'      => $works_civils_id,
                'ref'           => '1101',
                'item_desc'     => '1101 | Verge | Type FW2; preformed (Stakkabox)',
                'unit'          => RateCardUnit::LINE_ID,
                'rate'          => 360,
                'pin'           => 'red-dotted'
            ],
            [
                'works_id'      => $works_civils_id,
                'ref'           => '1121',
                'item_desc'     => '1121 | Footway | FTTH Toby Box; Tarmac',
                'unit'          => RateCardUnit::LINE_ID,
                'rate'          => 55,
                'pin'           => 'green-solid'
            ],
            [
                'works_id'      => $works_civils_id,
                'ref'           => '1140',
                'item_desc'     => '1140 | Fibre Cabinet Installation | Active Cabinet',
                'unit'          => RateCardUnit::POLYGON_ID,
                'rate'          => 60,
                'pin'           => 'purple'
            ],
            [
                'works_id'      => $works_civils_id,
                'ref'           => '1141',
                'item_desc'     => '1141 | Fibre Cabinet Installation | FDP',
                'unit'          => RateCardUnit::POLYGON_ID,
                'rate'          => 75,
                'pin'           => 'grey'
            ]
        ];

        foreach ($rate_cards as $card) {
            $card['contract_id'] = $contract_id;
            $card['created_at'] = date('Y-m-d H:i:s');
            $card['updated_at'] = date('Y-m-d H:i:s');
            DB::table('rate_cards')->insert($card);
        }
    }
}

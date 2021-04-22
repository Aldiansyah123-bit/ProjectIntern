<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BumdeseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bumdeses')->insert([
            [
                'name'      => 'Bumdes Madiun',
                'region_id' => '3519',
                'address'   => 'JL Pahlawan No 45'
            ],
            [
                'name'      => 'Bumdes Ponorogo',
                'region_id' => '3502',
                'address'   => 'JL Utama No 99'
            ]
        ]);
    }
}

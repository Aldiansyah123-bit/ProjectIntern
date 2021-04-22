<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmkmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('umkms')->insert([
            [
                'name'      => 'UMKM Madiun',
                'region_id' => '3519',
                'address'   => 'JL Pahlawan No 45'
            ],
            [
                'name'      => 'UMKM Ponorogo',
                'region_id' => '3502',
                'address'   => 'JL Utama No 99'
            ]
        ]);
    }
}

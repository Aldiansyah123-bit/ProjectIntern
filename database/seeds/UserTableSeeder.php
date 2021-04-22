<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'Admin',
                'region_id' => '3519',
                'address'   => 'JL Pahlawan No 45',
                'email'     => 'admin@gmail.com',
                'password'  => bcrypt('123456'),
            ],
            [
                'name'      => 'UMKM Madiun',
                'region_id' => '3519',
                'address'   => 'JL Pahlawan No 45',
                'email'     => 'umkm-madiun@gmail.com',
                'password'  => bcrypt('123456'),
            ],
            [
                'name'      => 'Bumdes Madiun',
                'region_id' => '3519',
                'address'   => 'JL Utama No 99',
                'email'     => 'bumdes-madiun@gmail.com',
                'password'  => bcrypt('123456'),
            ],
            [
                'name'      => 'User',
                'region_id' => '3519',
                'address'   => 'JL Pahlawan No 45',
                'email'     => 'user@gmail.com',
                'password'  => bcrypt('123456'),
            ]
        ]);
    }
}

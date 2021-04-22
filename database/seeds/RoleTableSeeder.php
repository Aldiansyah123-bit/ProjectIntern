<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name'          => 'Admin',
                'display_name'  => 'Administartor'
            ],
            [
                'name'          => 'user',
                'display_name'  => 'Normal User'
            ],
            [
                'name'          => 'bumdes',
                'display_name'  => 'Bumdes'
            ],
            [
                'name'          => 'umkm',
                'display_name'  => 'Umkm'
            ]
        ]);
    }
}

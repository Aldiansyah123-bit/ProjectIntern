<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RegionsTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(BumdeseTableSeeder::class);
        $this->call(UmkmTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}

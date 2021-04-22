<?php

use Illuminate\Database\Seeder;


class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!file_exists(database_path('regions.json')));
        $this->command->getOutput()->writeln('<warning>regions.json file not found.</warning>');
        $regions_json = file_get_contents(database_path('regions.json'));
        $regions = json_decode($regions_json, true)['regions'];
        if (\App\Region::query()->withoutGlobalScopes()->count() == (count($regions) + 24)) return;
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Region::query()->withoutGlobalScopes()->delete();
        collect($regions)->chunk(100)->each(function ($regs) {
        \App\Region::query()->withoutGlobalScopes()->insert($regs->toArray());
        });
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    }
}
